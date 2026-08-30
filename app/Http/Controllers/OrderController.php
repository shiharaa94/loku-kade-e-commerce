<?php

namespace App\Http\Controllers;

use App\Models\OrderDetails;
use App\Models\OrderHeader;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function publicTrackOrder(Request $request)
    {
        $queryStr = trim((string) $request->input('query'));

        if (empty($queryStr)) {
            return response()->json([
                'status' => 400,
                'message' => 'Please enter a tracking number, order number, or mobile number.'
            ], 400)->header('Access-Control-Allow-Origin', '*');
        }

        // Clean query: remove non-digits if checking for mobile
        $cleanPhone = preg_replace('/\D+/', '', $queryStr);

        // Search by tracking_number, order_number, or phone
        $orders = OrderHeader::where(function ($q) use ($queryStr, $cleanPhone) {
            $q->where('order_number', $queryStr)
                ->orWhere('tracking_number', $queryStr);
            
            if (strlen($cleanPhone) >= 9) {
                $phoneSuffix = substr($cleanPhone, -9);
                $q->orWhere('customer_pri_mobile', 'like', '%' . $phoneSuffix)
                  ->orWhere('customer_sec_mobile', 'like', '%' . $phoneSuffix);
            }
        })
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching your search. Please double check details.'
            ], 404)->header('Access-Control-Allow-Origin', '*');
        }

        $maskNameFunc = function ($name) {
            $parts = explode(' ', trim($name));
            $maskedParts = array_map(function ($part) {
                $len = strlen($part);
                if ($len <= 2) {
                    return $part;
                }
                return substr($part, 0, 1) . str_repeat('*', $len - 2) . substr($part, -1);
            }, $parts);
            return implode(' ', $maskedParts);
        };

        $results = $orders->map(function ($order) use ($maskNameFunc) {
            $items = OrderDetails::where('order_number', $order->order_number)
                ->get()
                ->map(function ($detail) {
                    return [
                        'product_name' => $detail->product_name,
                        'quantity' => $detail->quantity,
                        'selling_price' => $detail->selling_price,
                        'amount' => $detail->amount
                    ];
                });

            $shippingType = strtolower(trim($order->shipping_type ?? 'courier'));
            $isShippingAvailable = ($shippingType === 'courier' || !empty($order->tracking_number));

            $liveTracking = null;
            if ($isShippingAvailable && !empty($order->tracking_number)) {
                $liveTracking = \App\Services\LogisticsTrackingService::track($order->tracking_number);
            }

            return [
                'order_number' => $order->order_number,
                'tracking_number' => $order->tracking_number ?: 'Not Dispatched Yet',
                'customer_name' => $maskNameFunc($order->customer_name),
                'customer_city' => $order->customer_city,
                'total_amount' => $order->total_amount,
                'courier_status' => $liveTracking['status_formatted'] ?? ($order->courier_status ?: 'Pending'),
                'shipping_type' => $order->shipping_type ?? 'Courier',
                'is_shipping_available' => $isShippingAvailable,
                'live_tracking' => $liveTracking,
                'created_at' => $order->created_at ? $order->created_at->format('Y-m-d') : null,
                'items' => $items
            ];
        });

        return response()->json([
            'status' => 200,
            'orders' => $results
        ])->header('Access-Control-Allow-Origin', '*');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'       => 'required|string|max:255',
            'customer_email'      => 'nullable|email|max:255',
            'customer_address'    => 'required|string|max:500',
            'customer_city'       => 'required|string|max:255',
            'customer_pri_mobile' => 'required|string|max:20',
            'customer_sec_mobile' => 'nullable|string|max:20',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.selling_price' => 'required|numeric|min:0',
            'items.*.stock_id'    => 'nullable|integer',
            'shipping_type'       => 'required|string',
            'payment_type'        => 'required|in:COD,Online Transfer',
            'receipt_number'      => 'required_if:payment_type,Online Transfer|nullable|string|max:100',
            'receipt_image'       => 'required_if:payment_type,Online Transfer|nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $defaultAgentId = (int) config('services.default_agent_id', 1);

        DB::beginTransaction();

        try {
            // Handle receipt image upload if payment is Bank Transfer
            $receiptImagePath = null;
            if ($request->payment_type === 'Online Transfer' && $request->hasFile('receipt_image')) {
                $file = $request->file('receipt_image');
                $filename = 'receipt_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadDir = public_path('uploads/receipts');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $file->move($uploadDir, $filename);
                $receiptImagePath = 'uploads/receipts/' . $filename;
            }

            // Find last order for this website agent to increment sequence number
            $lastOrder = OrderHeader::where('agent_id', $defaultAgentId)
                ->where(function ($query) use ($defaultAgentId) {
                    $query->where('order_number', 'like', 'ORD-W-%')
                          ->orWhere('order_number', 'like', "ORD-{$defaultAgentId}-%");
                })
                ->orderBy('id', 'desc')
                ->first();

            $nextSequence = 1;
            if ($lastOrder) {
                $parts = explode('-', $lastOrder->order_number);
                if (count($parts) === 3) {
                    $nextSequence = intval($parts[2]) + 1;
                }
            }

            $orderNumber = sprintf("ORD-W-%04d", $nextSequence);
            $totalAmount = 0;
            $totalQty = 0;

            // Calculate item totals
            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['selling_price'];
                $totalQty += intval($item['quantity']);
            }

            // Get Courier shipping charge to calculate multi-buy discount
            $courierCharge = 350.00; // Default fallback
            $courierShipping = Shipping::where('type', 'Courier')->first();
            if ($courierShipping) {
                $courierCharge = $courierShipping->amount;
            }

            // Calculate multi-buy discount: courier_charge * (total_qty - 1)
            $discount = 0;
            if ($totalQty > 1) {
                $discount = $courierCharge * ($totalQty - 1);
            }

            // Deduct discount from total_amount
            $totalAmount = max(0, $totalAmount - $discount);

            // Save the actual courier charge for internal reference in database
            $shippingCost = $courierCharge;

            // Create Order Header
            $order = OrderHeader::create([
                'order_number'        => $orderNumber,
                'customer_name'       => $request->customer_name,
                'customer_email'      => $request->customer_email,
                'customer_address'    => $request->customer_address,
                'customer_city'       => $request->customer_city,
                'customer_pri_mobile' => $request->customer_pri_mobile,
                'customer_sec_mobile' => $request->customer_sec_mobile,
                'total_amount'        => $totalAmount,
                'agent_id'            => $defaultAgentId,
                'courier_status'      => 'Pending',
                'payment_type'        => $request->payment_type ?? 'COD',
                'receipt_number'      => $request->payment_type === 'Online Transfer' ? $request->receipt_number : null,
                'receipt_image'       => $receiptImagePath,
                'shipping_type'       => $request->shipping_type ?: 'Courier',
                'shipping_cost'       => $shippingCost,
                'commission'          => 0, // Direct customer orders have 0 commission
                'upload'              => 0,
                'notify'              => 0,
            ]);

            // Create details and deduct stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $stock = null;
                $costPrice = 0;

                if (!empty($item['stock_id'])) {
                    $stock = Stock::where('id', $item['stock_id'])
                        ->where('product_id', $item['product_id'])
                        ->first();
                }

                if (!$stock) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where(function ($query) use ($item) {
                            $query->where('selling_price', $item['selling_price'])
                                ->orWhere(DB::raw('selling_price - discount'), $item['selling_price']);
                        })
                        ->where('quantity', '>', 0)
                        ->first();
                }

                // Fallback to latest positive stock batch
                if (!$stock) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where('quantity', '>', 0)
                        ->latest()
                        ->first();
                }

                // Ultimate fallback: any stock batch
                if (!$stock) {
                    $stock = Stock::where('product_id', $item['product_id'])->latest()->first();
                }

                if ($stock) {
                    $costPrice = $stock->cost_price;
                    if ($stock->quantity >= $item['quantity']) {
                        $stock->decrement('quantity', $item['quantity']);
                    } else {
                        // If requested quantity is more than available, set stock to 0 and log warning
                        Log::warning("Order {$orderNumber}: Stock quantity for product {$item['product_id']} was {$stock->quantity}, but {$item['quantity']} was ordered. Setting stock to 0.");
                        $stock->quantity = 0;
                        $stock->save();
                    }
                }

                OrderDetails::create([
                    'order_number' => $orderNumber,
                    'product_id' => $item['product_id'],
                    'stock_id' => $stock ? $stock->id : null,
                    'product_name' => $product->product_name,
                    'quantity' => $item['quantity'],
                    'cost_price' => $costPrice,
                    'selling_price' => $item['selling_price'],
                    'amount' => $item['quantity'] * $item['selling_price'],
                    'agent_id' => $defaultAgentId,
                    'exchange' => 0,
                ]);
            }

            DB::commit();

            // If customer is logged in and save_address is checked (or no address saved yet), update profile address
            if (auth()->check()) {
                $loggedInUser = auth()->user();
                $shouldSave = $request->boolean('save_address', true) || empty($loggedInUser->address);
                if ($shouldSave) {
                    $loggedInUser->update([
                        'address'    => $request->customer_address,
                        'city'       => $request->customer_city,
                        'pri_mobile' => $request->customer_pri_mobile,
                        'sec_mobile' => $request->customer_sec_mobile,
                    ]);
                }
            }

            // Send Order Placed Email if customer email is provided and not empty
            if (!empty($order->customer_email) && filter_var($order->customer_email, FILTER_VALIDATE_EMAIL)) {
                try {
                    $order->load('details');
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)
                        ->send(new \App\Mail\OrderPlacedMail($order));
                } catch (\Exception $mailEx) {
                    Log::error("Failed to send order placed email for order {$orderNumber}: " . $mailEx->getMessage());
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Order Placed Successfully',
                'order_number' => $orderNumber
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to place online order: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'status' => 500,
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchCities()
    {
        try {
            $jsonData = file_get_contents('https://sri-lanka-cities-api.vercel.app/api/getAllCities');
            $data = json_decode($jsonData, true);

            if (isset($data['data'])) {
                $formatted = [];
                foreach ($data['data'] as $city) {
                    $formatted[] = [
                        'id' => $city['name'], // Value
                        'text' => $city['name'] . ' (' . $city['zipCode'] . ')' // Display Data
                    ];
                }
                return response()->json(['results' => $formatted]);
            }

            return response()->json(['results' => []]);
        } catch (\Exception $e) {
            return response()->json(['results' => []]);
        }
    }

    public function showTrackingPage($token)
    {
        $order = OrderHeader::where('secure_token', $token)->firstOrFail();
        $order->load('details');
        
        $shippingType = strtolower(trim($order->shipping_type ?? 'courier'));
        $isShippingAvailable = ($shippingType === 'courier' || !empty($order->tracking_number));

        $liveTracking = null;
        if ($isShippingAvailable && !empty($order->tracking_number)) {
            $liveTracking = \App\Services\LogisticsTrackingService::track($order->tracking_number);
        }
        
        return view('pages.public.orders.track', [
            'order' => $order,
            'isShippingAvailable' => $isShippingAvailable,
            'liveTracking' => $liveTracking
        ]);
    }

    public function showReviewPage($token)
    {
        $order = OrderHeader::where('secure_token', $token)->firstOrFail();
        $order->load('details');
        
        // Find existing reviews for this order
        $existingReviews = \App\Models\ProductReview::where('order_number', $order->order_number)
            ->get()
            ->keyBy('product_id');
            
        $isEditable = true;
        $editRestrictionMessage = '';
        
        if ($existingReviews->isNotEmpty()) {
            // Check the first review's created_at date
            $firstReview = $existingReviews->first();
            if (!$firstReview->created_at->isToday()) {
                $isEditable = false;
                $editRestrictionMessage = 'Reviews can only be edited on the day of submission.';
            }
        }
        
        return view('pages.public.orders.review', [
            'order' => $order,
            'existingReviews' => $existingReviews,
            'isEditable' => $isEditable,
            'editRestrictionMessage' => $editRestrictionMessage
        ]);
    }

    public function submitOrderReviews(Request $request, $token)
    {
        $order = OrderHeader::where('secure_token', $token)->firstOrFail();
        
        // Find existing reviews for this order
        $existingReviews = \App\Models\ProductReview::where('order_number', $order->order_number)->get();
        if ($existingReviews->isNotEmpty()) {
            $firstReview = $existingReviews->first();
            if (!$firstReview->created_at->isToday()) {
                return back()->with('error', 'Reviews can only be edited on the day of submission.');
            }
        }
        
        $request->validate([
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|array',
            'comments.*' => 'nullable|string|max:1000'
        ]);
        
        foreach ($request->ratings as $productId => $rating) {
            $comment = isset($request->comments[$productId]) ? trim($request->comments[$productId]) : null;
            
            \App\Models\ProductReview::updateOrCreate(
                [
                    'order_number' => $order->order_number,
                    'product_id' => $productId
                ],
                [
                    'customer_name' => $order->customer_name,
                    'rating' => $rating,
                    'comment' => $comment
                ]
            );
        }
        
        return back()->with('success', 'Thank you! Your reviews have been submitted successfully.');
    }

    public function simulateDelivery($order_number)
    {
        $order = OrderHeader::where('order_number', $order_number)->firstOrFail();
        
        $order->courier_status = 'Delivered';
        $order->save();
        
        return "Order {$order_number} status updated to 'Delivered' and review request email sent successfully to {$order->customer_email}!";
    }

    /**
     * Cancel / delete a pending order by the authenticated client.
     */
    public function clientCancelOrder(Request $request, $order_number)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'Please log in to cancel your order.'
            ], 401);
        }

        $user = auth()->user();

        $order = OrderHeader::where('order_number', $order_number)
            ->where(function ($q) use ($user) {
                $q->where('customer_email', $user->email)
                  ->orWhere('agent_id', $user->id);
            })
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found or you do not have permission to cancel this order.'
            ], 404);
        }

        // Only allow cancellation if order status is pending
        $rawStatus = strtolower(trim($order->courier_status ?? 'pending'));
        if (!in_array($rawStatus, ['pending', ''])) {
            return response()->json([
                'status' => 400,
                'message' => 'This order has already been processed or dispatched and cannot be cancelled online. Please contact support via WhatsApp.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $order->load('details');

            // 1. Prepare detailed snapshot for emails before deletion
            $itemsSnapshot = [];
            foreach ($order->details as $detail) {
                $itemsSnapshot[] = [
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product_name,
                    'quantity' => (int) $detail->quantity,
                    'selling_price' => (float) $detail->selling_price,
                    'amount' => (float) $detail->amount,
                ];

                // 2. Restore stock inventory
                if (!empty($detail->stock_id)) {
                    $stock = Stock::find($detail->stock_id);
                    if ($stock) {
                        $stock->increment('quantity', (int) $detail->quantity);
                    }
                } else {
                    // Fallback to first stock row of this product
                    $stock = Stock::where('product_id', $detail->product_id)->first();
                    if ($stock) {
                        $stock->increment('quantity', (int) $detail->quantity);
                    }
                }
            }

            $orderDataSnapshot = [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name ?: ($user->first_name . ' ' . $user->last_name),
                'customer_email' => $order->customer_email ?: $user->email,
                'customer_pri_mobile' => $order->customer_pri_mobile ?: $user->pri_mobile,
                'customer_sec_mobile' => $order->customer_sec_mobile ?: $user->sec_mobile,
                'customer_address' => $order->customer_address ?: $user->address,
                'customer_city' => $order->customer_city ?: $user->city,
                'total_amount' => (float) $order->total_amount,
                'items' => $itemsSnapshot,
                'deleted_at' => now()->format('Y-m-d H:i:s T'),
            ];

            // 3. Delete order details and order header records
            $order->details()->delete();
            $order->delete();

            DB::commit();

            // 4. Send Email Notification to Admin (info@lokukade.lk)
            try {
                \Illuminate\Support\Facades\Mail::to('info@lokukade.lk')
                    ->send(new \App\Mail\ClientOrderDeletedMail($orderDataSnapshot));
            } catch (\Exception $adminMailEx) {
                Log::error("Failed to send client order cancellation email to admin for order {$order_number}: " . $adminMailEx->getMessage());
            }

            // 5. Send Confirmation Email to Customer
            if (!empty($orderDataSnapshot['customer_email']) && filter_var($orderDataSnapshot['customer_email'], FILTER_VALIDATE_EMAIL)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($orderDataSnapshot['customer_email'])
                        ->send(new \App\Mail\CustomerOrderCancelledMail($orderDataSnapshot));
                } catch (\Exception $custMailEx) {
                    Log::error("Failed to send cancellation confirmation email to customer {$orderDataSnapshot['customer_email']} for order {$order_number}: " . $custMailEx->getMessage());
                }
            }

            return response()->json([
                'status' => 200,
                'message' => "Order #{$order_number} has been cancelled successfully."
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error while client cancelling order {$order_number}: " . $e->getMessage() . "\n" . $e->getTraceAsString());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while cancelling your order. Please try again or contact WhatsApp support.'
            ], 500);
        }
    }
}
