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
        // 1. Truncate existing dummy reviews
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductReview::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $allProducts = Product::all();
        if ($allProducts->isEmpty()) {
            return;
        }

        $sales = DB::table('order_details')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->pluck('total_sold', 'product_id');

        $customerNames = [
            'Kasun Perera', 'Nuwan Pradeep', 'Dinusha Fernando', 'Chamara Silva',
            'Sanduni Jayawardena', 'Tharindu Senanayake', 'Dilshan Bandara', 'Nadeesha Karunaratne',
            'Lahiru Dissanayake', 'Chathurika Mendis', 'Ashen Rathnayake', 'Sachini Gamage',
            'Ishara Wijesinghe', 'Roshan Alwis', 'Danushka Jayasuriya', 'Pramod Madushanka',
            'Kavinda Wickramasinghe', 'Hansi Abeysekara', 'Thilini Gunasekara', 'Mahesh Kumara',
            'Supun Jayalath', 'Amila Sampath', 'Malsha Weerasinghe', 'Sahan Pathirana',
            'Niroshan De Silva', 'Gayani Rajapaksha', 'Buddhika Senaratne', 'Hashan Maduranga',
            'Rasika Priyadarshana', 'Anushka Madushani', 'Dimuthu Jayawardena', 'Kushan Vithanage',
            'Dilantha Hettiarachchi', 'Udeshika Samanmali', 'Ramesh Fonseka', 'Harsha Liyanage',
            'Charith Wickramaratne', 'Lakshan Fernando', 'Shehan Athukorala', 'Nalaka Bandara',
            'Suraj Gunawardena', 'Isuru Warnakulasuriya', 'Madhuranga Peiris', 'Janaka Edirisinghe',
            'Sajith Kumara', 'Praveen Jayasooriya', 'Shenal Perera', 'Gayantha Koralage',
            'Manula Ranasinghe', 'Oshada Thennakoon', 'Vindya Senanayake', 'Sewwandi Rupasinghe',
            'Chathuri Herath', 'Niluka Sandamali', 'Madushani Ekanayake', 'Poornima Dasanayake',
            'Kaveesha Navodya', 'Bimsara Jayakodi', 'Piyumi Wijekoon', 'Shalika Samaranayake',
            'Naveen Dananjaya', 'Chathuranga Prasad', 'Menaka Liyanarachchi', 'Thilina Madushan',
            'Hansani Jayasinghe', 'Ruwanthi Kariyawasam', 'Dhanushka Priyankara', 'Kusal Mendis'
        ];

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

            foreach ($ratings as $r) {
                $name = $customerNames[array_rand($customerNames)];
                $comment = $r === 5 ? $fiveStarComments[array_rand($fiveStarComments)] : $fourStarComments[array_rand($fourStarComments)];
                $createdAt = Carbon::now()->subDays(rand(2, 120))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                $batch[] = [
                    'product_id' => $product->id,
                    'order_number' => null,
                    'customer_name' => $name,
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

