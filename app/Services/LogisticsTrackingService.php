<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class LogisticsTrackingService
{
    const DEX_SEARCH_URL = 'https://logistics.dex.lk/api/search_packages';
    const DEX_HISTORY_URL = 'https://logistics.dex.lk/api/get_package_history';
    const CITYPAK_URL = 'https://track.citypak.lk/track';

    /**
     * Detect the logistics provider based on tracking number pattern.
     */
    public static function detectProvider(?string $trackingNumber): string
    {
        if (empty($trackingNumber)) {
            return 'none';
        }

        $t = strtoupper(trim($trackingNumber));

        // DEX / Daraz Logistics
        if (str_starts_with($t, 'LK-DM-') || str_starts_with($t, 'LK-DEX') || str_starts_with($t, 'DEX-') || str_contains($t, 'DEX')) {
            return 'dex';
        }

        // Citypak by Advantis (usually starts with D followed by numbers, e.g. D14883919)
        if (preg_match('/^D\d{6,12}$/i', $t) || str_starts_with($t, 'CP-') || str_starts_with($t, 'CITYPAK')) {
            return 'citypak';
        }

        return 'general';
    }

    /**
     * Fetch unified tracking details from the detected provider.
     */
    public static function track(?string $trackingNumber): ?array
    {
        if (empty($trackingNumber)) {
            return null;
        }

        $provider = self::detectProvider($trackingNumber);

        if ($provider === 'dex') {
            return self::trackDex($trackingNumber);
        }

        if ($provider === 'citypak') {
            return self::trackCitypak($trackingNumber);
        }

        return null;
    }

    /**
     * Track DEX (Daraz Logistics) package via official API.
     */
    public static function trackDex(string $trackingNumber): ?array
    {
        try {
            $trackingNumber = trim($trackingNumber);

            // 1. Search package
            $response = Http::withHeaders([
                'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json, text/plain, */*',
                'Origin'       => 'https://logistics.dex.lk',
                'Referer'      => 'https://logistics.dex.lk/tracking?references=' . urlencode($trackingNumber)
            ])->timeout(8)->post(self::DEX_SEARCH_URL, [
                'trackingNumbers' => [$trackingNumber]
            ]);

            if (!$response->successful()) {
                return self::dexFallback($trackingNumber);
            }

            $searchData = $response->json();
            if (empty($searchData['success']) || empty($searchData['data'][0])) {
                return self::dexFallback($trackingNumber);
            }

            $packageInfo = $searchData['data'][0];
            $packageCode = $packageInfo['packageCode'] ?? null;
            $rawStatus = $packageInfo['packageStatus'] ?? 'unknown';

            // 2. Get detailed history
            $timeline = [];
            if ($packageCode) {
                $historyResponse = Http::withHeaders([
                    'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json, text/plain, */*',
                    'Origin'       => 'https://logistics.dex.lk',
                    'Referer'      => 'https://logistics.dex.lk/tracking?references=' . urlencode($trackingNumber)
                ])->timeout(8)->post(self::DEX_HISTORY_URL, [
                    'packageCode'    => $packageCode,
                    'trackingNumber' => $trackingNumber
                ]);

                if ($historyResponse->successful()) {
                    $historyData = $historyResponse->json();
                    if (!empty($historyData['data']['timeline'])) {
                        foreach ($historyData['data']['timeline'] as $item) {
                            $timeMs = $item['processTime'] ?? null;
                            $formattedDate = $timeMs ? date('Y-m-d H:i:s', $timeMs / 1000) : null;
                            $humanDate = $timeMs ? date('M d, Y - h:i A', $timeMs / 1000) : null;

                            $timeline[] = [
                                'status'        => self::formatStatusName($item['status'] ?? ''),
                                'raw_status'    => $item['status'] ?? '',
                                'timestamp'     => $formattedDate,
                                'human_time'    => $humanDate,
                                'location'      => $item['location'] ?? null,
                                'shipping_provider' => $item['shippingProvider'] ?? 'LK-DEX',
                                'reason'        => !empty($item['reasonCode']) ? ucwords($item['reasonCode']) : null
                            ];
                        }
                    }
                }
            }

            return [
                'provider'         => 'dex',
                'provider_name'    => 'Daraz Logistics (DEX)',
                'provider_badge'   => 'bg-danger text-white',
                'provider_icon'    => 'bi-box-seam',
                'tracking_number'  => $trackingNumber,
                'package_code'     => $packageCode,
                'status_raw'       => $rawStatus,
                'status_formatted' => self::formatStatusName($rawStatus),
                'status_type'      => self::categorizeStatus($rawStatus),
                'timeline'         => $timeline,
                'direct_url'       => 'https://logistics.dex.lk/tracking?references=' . urlencode($trackingNumber)
            ];
        } catch (\Exception $e) {
            Log::warning('DEX Tracking Exception: ' . $e->getMessage());
            return self::dexFallback($trackingNumber);
        }
    }

    /**
     * Fallback structure for DEX when external service times out.
     */
    protected static function dexFallback(string $trackingNumber): array
    {
        return [
            'provider'         => 'dex',
            'provider_name'    => 'Daraz Logistics (DEX)',
            'provider_badge'   => 'bg-danger text-white',
            'provider_icon'    => 'bi-box-seam',
            'tracking_number'  => $trackingNumber,
            'package_code'     => null,
            'status_raw'       => 'in_transit',
            'status_formatted' => 'In Transit via DEX',
            'status_type'      => 'shipped',
            'timeline'         => [],
            'direct_url'       => 'https://logistics.dex.lk/tracking?references=' . urlencode($trackingNumber)
        ];
    }

    /**
     * Track Citypak Courier package via official tracking webpage.
     */
    public static function trackCitypak(string $trackingNumber): ?array
    {
        try {
            $trackingNumber = trim($trackingNumber);
            $url = self::CITYPAK_URL . '?tracking_number=' . urlencode($trackingNumber);

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
            ])->timeout(8)->get($url);

            if (!$response->successful()) {
                return self::citypakFallback($trackingNumber);
            }

            $html = $response->body();
            if (empty($html)) {
                return self::citypakFallback($trackingNumber);
            }

            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // Extract main status from page
            $mainStatus = 'In Transit';
            $pageText = $dom->textContent;
            if (stripos($pageText, 'DELIVERED') !== false && stripos($pageText, 'RETURNED TO SENDER') !== false) {
                $mainStatus = 'Delivered / Returned';
            } elseif (stripos($pageText, 'DELIVERED') !== false) {
                $mainStatus = 'Delivered';
            } elseif (stripos($pageText, 'OUT FOR DELIVERY') !== false) {
                $mainStatus = 'Out for Delivery';
            } elseif (stripos($pageText, 'RETURN') !== false) {
                $mainStatus = 'Returned';
            }

            // Extract Tracking History Table
            $timeline = [];
            $tables = $dom->getElementsByTagName('table');
            if ($tables->length > 0) {
                $table = $tables->item(0);
                $rows = $table->getElementsByTagName('tr');

                foreach ($rows as $index => $row) {
                    $tds = $row->getElementsByTagName('td');
                    if ($tds->length >= 4) {
                        $dateStr = trim($tds->item(0)->textContent);
                        $timeStr = trim($tds->item(1)->textContent);
                        $statusStr = trim(preg_replace('/\s+/', ' ', $tds->item(2)->textContent));
                        $locationStr = trim(preg_replace('/\s+/', ' ', $tds->item(3)->textContent));

                        $humanTime = $dateStr . ($timeStr ? ' ' . $timeStr : '');

                        $timeline[] = [
                            'status'        => $statusStr,
                            'raw_status'    => strtolower($statusStr),
                            'timestamp'     => $humanTime,
                            'human_time'    => $humanTime,
                            'location'      => $locationStr ?: null,
                            'shipping_provider' => 'Citypak by Advantis',
                            'reason'        => null
                        ];
                    }
                }
            }

            // Reverse Citypak timeline so the newest / highest datetime is first (at the top)
            $timeline = array_reverse($timeline);

            if (!empty($timeline[0]['status'])) {
                $mainStatus = $timeline[0]['status'];
            }

            return [
                'provider'         => 'citypak',
                'provider_name'    => 'Citypak by Advantis',
                'provider_badge'   => 'bg-dark text-white',
                'provider_icon'    => 'bi-truck',
                'tracking_number'  => $trackingNumber,
                'package_code'     => null,
                'status_raw'       => strtolower($mainStatus),
                'status_formatted' => $mainStatus,
                'status_type'      => self::categorizeStatus($mainStatus),
                'timeline'         => $timeline,
                'direct_url'       => $url
            ];
        } catch (\Exception $e) {
            Log::warning('Citypak Tracking Exception: ' . $e->getMessage());
            return self::citypakFallback($trackingNumber);
        }
    }

    /**
     * Fallback structure for Citypak when scraping fails.
     */
    protected static function citypakFallback(string $trackingNumber): array
    {
        return [
            'provider'         => 'citypak',
            'provider_name'    => 'Citypak by Advantis',
            'provider_badge'   => 'bg-dark text-white',
            'provider_icon'    => 'bi-truck',
            'tracking_number'  => $trackingNumber,
            'package_code'     => null,
            'status_raw'       => 'in_transit',
            'status_formatted' => 'Dispatched via Citypak',
            'status_type'      => 'shipped',
            'timeline'         => [],
            'direct_url'       => self::CITYPAK_URL . '?tracking_number=' . urlencode($trackingNumber)
        ];
    }

    /**
     * Convert raw status strings into human-readable labels.
     */
    public static function formatStatusName(string $status): string
    {
        $status = str_replace('_', ' ', strtolower(trim($status)));
        return ucwords($status);
    }

    /**
     * Categorize status into standard bucket (to_ship, shipped, delivered, returns).
     */
    public static function categorizeStatus(string $status): string
    {
        $s = strtolower($status);
        if (str_contains($s, 'delivered') && !str_contains($s, 'not delivered') && !str_contains($s, 'failed')) {
            return 'delivered';
        }
        if (str_contains($s, 'return') || str_contains($s, 'fail') || str_contains($s, 'cancel')) {
            return 'returns';
        }
        if (str_contains($s, 'pending') || str_contains($s, 'received in facility') && !str_contains($s, 'out')) {
            return 'to_ship';
        }
        return 'shipped';
    }
}
