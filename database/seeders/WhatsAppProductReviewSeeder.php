<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhatsAppProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Truncate existing reviews
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductReview::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $allProducts = Product::all();
        if ($allProducts->isEmpty()) {
            return;
        }

        // 2. Fetch real orders by product from order_details & order_headers
        $realOrdersByProduct = DB::table('order_details')
            ->join('order_headers', 'order_details.order_number', '=', 'order_headers.order_number')
            ->select(
                'order_details.product_id',
                'order_details.order_number',
                'order_headers.customer_name',
                'order_headers.created_at as order_date'
            )
            ->whereNotNull('order_headers.customer_name')
            ->where('order_headers.customer_name', '!=', '')
            ->get()
            ->groupBy('product_id');

        // 3. Extract unique pool of actual customer names from all orders in order_headers
        $realCustomerNamePool = DB::table('order_headers')
            ->whereNotNull('customer_name')
            ->where('customer_name', '!=', '')
            ->pluck('customer_name')
            ->map(function ($name) {
                $clean = trim(preg_replace('/\s+/', ' ', $name));
                return ucwords(strtolower($clean));
            })
            ->filter(function ($name) {
                return strlen($name) >= 3;
            })
            ->unique()
            ->values()
            ->all();

        // Fallback default Sri Lankan names if database pool is empty
        if (empty($realCustomerNamePool)) {
            $realCustomerNamePool = [
                'Kasun Perera', 'Nuwan Pradeep', 'Dinusha Fernando', 'Chamara Silva',
                'Sanduni Jayawardena', 'Tharindu Senanayake', 'Dilshan Bandara', 'Nadeesha Karunaratne',
                'Lahiru Dissanayake', 'Chathurika Mendis', 'Ashen Rathnayake', 'Sachini Gamage',
                'Ishara Wijesinghe', 'Roshan Alwis', 'Danushka Jayasuriya', 'Pramod Madushanka'
            ];
        }

        $sales = DB::table('order_details')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->pluck('total_sold', 'product_id');

        $fiveStarComments = [
            'Excellent product! Highly recommended. Quality is top notch.',
            'Good quality item. Fast delivery within 2 days. Thank you Loku Kade!',
            'Perfect buy, exactly like in the picture and works smoothly.',
            'Amazing service and very fast response on WhatsApp. Will buy again!',
            'Super quality product. Definitely value for money!',
            'Product is very durable and high quality. Received nicely packed.',
            'Very satisfied with this item. Highly recommended to everyone.',
            'Awesome product! Delivery was very fast and item condition is 100%.',
            'Item eka godak hodai. Packaging ekath super. Thanks a lot!',
            'Gedaratama genath dunna dawas 2n. Product quality eka niyamai.',
            'Very useful product. Works perfectly as described.',
            'High quality materials. Totally worth the price paid.',
            'Great communication and genuine product. 10/10 recommend.',
            'Ordered via WhatsApp before and received top quality item. Excellent!',
            'Best customer service and product quality is outstanding.',
            'Item eka supiri, kiwwa widiyatama thibba. Godak sthuthiy!',
            'Very fast islandwide delivery. Product in perfect condition.',
            'Satisfied with the purchase. Good finish and robust build.',
            'Received carefully packed without any damage. Excellent product.',
            'Second time purchasing this. Consistent quality and great seller.',
            'Item is working without any issue. Trusted seller!',
            'Very good condition, package eka open karala balala ganna puluwan una.',
            'Quality is great for this price. Thank you for the fast dispatch.',
            'Fast response on WhatsApp and quick delivery to Kandy.',
            'Honest seller with good products. 5 stars from me.'
        ];

        $fourStarComments = [
            'Good quality item. Satisfied with the product.',
            'Nice packaging and product is also good. Useful item.',
            'Good purchase, fast courier service. Works well.',
            'Useful item, looks durable and works as expected.',
            'Value for money. Minor delay in delivery but product is good.',
            'Item eka hodai, use karanna lesiy. Satisfied with the order.',
            'Good quality for this price range. Recommended.',
            'Product is good and matches the description nicely.',
            'Delivery took 3 days but item condition is very good.',
            'Worth the price. Overall good experience buying from Loku Kade.',
            'Decent item, works fine as expected.',
            'Satisfied with the purchase. Good communication by seller.'
        ];

        $batch = [];

        foreach ($allProducts as $product) {
            $sold = (int)($sales[$product->id] ?? 0);
            $productOrders = collect($realOrdersByProduct->get($product->id, []))->shuffle();

            if ($sold > 0) {
                // Around 90% of sold quantity, minimum 4 reviews
                $count = max(4, (int)round($sold * 0.90));
            } else {
                // Pre-site WhatsApp customer reviews for items without DB sales
                $count = rand(3, 7);
            }

            // Ratio of 5-star reviews to keep average strictly between 4.6 and 4.9
            $ratio5 = rand(65, 88) / 100.0;
            $fiveCount = (int)round($count * $ratio5);
            $fourCount = $count - $fiveCount;

            // Ensure at least one 4-star review so it feels authentic (e.g. 4.7 - 4.9)
            if ($count >= 2 && $fourCount < 1) {
                $fourCount = 1;
                $fiveCount = $count - 1;
            }

            $ratings = array_merge(array_fill(0, $fiveCount, 5), array_fill(0, $fourCount, 4));
            shuffle($ratings);

            for ($i = 0; $i < $count; $i++) {
                $r = $ratings[$i];
                $comment = $r === 5 ? $fiveStarComments[array_rand($fiveStarComments)] : $fourStarComments[array_rand($fourStarComments)];

                // Check if we have an actual order record for this product
                if ($i < $productOrders->count()) {
                    $order = $productOrders[$i];
                    $rawName = trim(preg_replace('/\s+/', ' ', $order->customer_name));
                    $customerName = ucwords(strtolower($rawName));
                    $orderNumber = $order->order_number;
                    
                    // Set review date 1-5 days after real order creation
                    $orderTime = !empty($order->order_date) ? Carbon::parse($order->order_date) : Carbon::now()->subDays(rand(10, 60));
                    $createdAt = $orderTime->addDays(rand(1, 4))->addHours(rand(1, 12));
                    if ($createdAt->isFuture()) {
                        $createdAt = Carbon::now()->subHours(rand(1, 48));
                    }
                } else {
                    // Use a real customer name from the full database orders pool
                    $customerName = $realCustomerNamePool[array_rand($realCustomerNamePool)];
                    $orderNumber = null;
                    $createdAt = Carbon::now()->subDays(rand(2, 120))->subHours(rand(1, 23))->subMinutes(rand(1, 59));
                }

                $batch[] = [
                    'product_id' => $product->id,
                    'order_number' => $orderNumber,
                    'customer_name' => $customerName,
                    'rating' => $r,
                    'comment' => $comment,
                    'created_at' => $createdAt->toDateTimeString(),
                    'updated_at' => $createdAt->toDateTimeString(),
                ];

                if (count($batch) >= 200) {
                    ProductReview::insert($batch);
                    $batch = [];
                }
            }
        }

        if (!empty($batch)) {
            ProductReview::insert($batch);
        }
    }
}


