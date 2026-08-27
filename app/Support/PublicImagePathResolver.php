<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PublicImagePathResolver
{
    protected static array $cache = [];

    public static function resolveAssetUrl(?string $path): ?string
    {
        $normalized = self::normalize($path);
        if ($normalized === null) {
            return null;
        }

        $resolvedPath = self::resolveRelativePath($normalized);
        if ($resolvedPath !== null) {
            $staticUrl = self::resolveStaticUrl($resolvedPath);
            if ($staticUrl !== null) {
                return $staticUrl;
            }
            $targetPath = $resolvedPath;
        } else {
            $targetPath = $normalized;
        }

        $encodedPath = str_replace('%2F', '/', rawurlencode($targetPath));
        // Redirect non-local media files to the backend system
        $backendUrl = rtrim(config('services.backend_url', 'https://app.lokukade.lk'), '/');
        return $backendUrl . '/media/' . ltrim($encodedPath, '/');
    }

    protected static function resolveStaticUrl(string $relativePath): ?string
    {
        $publicStorage = public_path('storage');
        if (File::exists($publicStorage) && Storage::disk('public')->exists($relativePath)) {
            return Storage::disk('public')->url($relativePath);
        }

        if (File::exists(public_path($relativePath))) {
            $encodedPath = str_replace('%2F', '/', rawurlencode($relativePath));
            return url('/' . ltrim($encodedPath, '/'));
        }

        return null;
    }

    protected static function resolveRelativePath(?string $path): ?string
    {
        $normalized = self::normalize($path);
        if ($normalized === null) {
            return null;
        }

        if (array_key_exists($normalized, self::$cache)) {
            return self::$cache[$normalized];
        }

        if (self::existsAnywhere($normalized)) {
            return self::$cache[$normalized] = $normalized;
        }

        $resolved = self::resolveFallback($normalized);
        self::$cache[$normalized] = $resolved;

        return $resolved;
    }

    protected static function normalize(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        $clean = trim(str_replace('\\', '/', $path));
        $clean = ltrim(rawurldecode($clean), '/');

        $marker = '/public/';
        $markerPos = stripos($clean, $marker);
        if ($markerPos !== false) {
            $clean = substr($clean, $markerPos + strlen($marker));
        }

        return $clean !== '' ? $clean : null;
    }

    protected static function existsAnywhere(string $relativePath): bool
    {
        if (Storage::disk('public')->exists($relativePath)) {
            return true;
        }

        return File::exists(public_path($relativePath));
    }

    protected static function resolveFallback(string $relativePath): ?string
    {
        $dir = str_replace('\\', '/', pathinfo($relativePath, PATHINFO_DIRNAME));
        $base = pathinfo($relativePath, PATHINFO_BASENAME);
        $name = pathinfo($relativePath, PATHINFO_FILENAME);
        $ext = pathinfo($relativePath, PATHINFO_EXTENSION);

        $candidateNames = array_filter(array_unique([
            $base,
            str_replace(' ', '_', $base),
            str_replace('_', ' ', $base),
            preg_replace('/\.(\d+)\.([a-zA-Z0-9]+)$/', '_$1.$2', $base),
            preg_replace('/_(\d+)\.([a-zA-Z0-9]+)$/', '.$1.$2', $base),
        ]));

        foreach ($candidateNames as $candidateName) {
            $candidatePath = trim($dir . '/' . $candidateName, '/');
            if (self::existsAnywhere($candidatePath)) {
                return $candidatePath;
            }
        }

        $best = self::findBestMatchByDirectory($dir, $base, $name, $ext, true);
        if ($best !== null) {
            return $best;
        }

        return self::findBestMatchByDirectory($dir, $base, $name, $ext, false);
    }

    protected static function findBestMatchByDirectory(string $dir, string $base, string $name, string $ext, bool $storage): ?string
    {
        $files = self::listDirectoryFiles($dir, $storage);
        if (empty($files)) {
            return null;
        }

        $prefixes = array_filter([
            self::extractPrefix($name),
            str_contains($name, '.') ? explode('.', $name, 2)[0] : $name,
            str_contains($name, '_') ? explode('_', $name, 3)[0] : null,
            str_contains($name, ' ') ? explode(' ', $name, 3)[0] : null,
        ]);

        $bestPath = null;
        $bestDistance = PHP_INT_MAX;

        foreach ($files as $fileName) {
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

            if ($ext !== '' && strcasecmp($ext, $fileExt) !== 0) {
                continue;
            }

            foreach ($prefixes as $prefix) {
                if ($prefix !== '' && !str_starts_with($fileName, $prefix)) {
                    continue;
                }

                $distance = levenshtein($base, $fileName);
                if ($distance < $bestDistance) {
                    $bestDistance = $distance;
                    $bestPath = trim($dir . '/' . $fileName, '/');
                }
            }
        }

        return $bestDistance <= 16 ? $bestPath : null;
    }

    protected static function listDirectoryFiles(string $dir, bool $storage): array
    {
        if ($storage) {
            if (!Storage::disk('public')->exists($dir)) {
                return [];
            }

            $all = Storage::disk('public')->files($dir);
            return array_map(static fn ($path) => basename($path), $all);
        }

        $directory = public_path(trim($dir, '/'));
        if (!File::isDirectory($directory)) {
            return [];
        }

        return array_map(static fn ($file) => $file->getFilename(), File::files($directory));
    }

    protected static function extractPrefix(string $name): ?string
    {
        if (preg_match('/^(product[_\s]\d+[_\s])/', $name, $matches)) {
            return str_replace(' ', '_', $matches[1]);
        }

        if (str_starts_with($name, 'catalog_feedback_') || str_starts_with($name, 'catalog feedback ')) {
            return 'catalog_feedback_';
        }

        return null;
    }
}
