<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryAndReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create categories
        $categoriesData = [
            ['name' => 'Dishwasher Parts & Accessories', 'icon_image' => 'bi-gear-wide-connected'],
            ['name' => 'Seasonal & Decorative', 'icon_image' => 'bi-palette'],
            ['name' => 'Bunting Bags', 'icon_image' => 'bi-bag'],
            ['name' => 'Stationery Fasteners', 'icon_image' => 'bi-paperclip'],
            ['name' => 'Literature', 'icon_image' => 'bi-book'],
            ['name' => 'Down Jackets', 'icon_image' => 'bi-tags-fill'],
            ['name' => 'Table Lamps', 'icon_image' => 'bi-lightbulb-fill'],
            ['name' => 'Hats & Caps', 'icon_image' => 'bi-person-fill-gear'],
            ['name' => 'Power Routers', 'icon_image' => 'bi-router-fill'],
            ['name' => 'Popcorn Makers', 'icon_image' => 'bi-egg-fried'],
            ['name' => 'Art Books', 'icon_image' => 'bi-book-half'],
            ['name' => 'RAM', 'icon_image' => 'bi-cpu-fill'],
            ['name' => 'Rawhides', 'icon_image' => 'bi-shield-shaded'],
            ['name' => 'Others', 'icon_image' => 'bi-three-dots'],
            ['name' => 'Classical', 'icon_image' => 'bi-music-note-beamed'],
            ['name' => 'Decorative Door Stops', 'icon_image' => 'bi-door-closed-fill'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'icon_image' => $cat['icon_image'],
                ]
            );
        }

        // 2. Assign categories and fulfillment types to existing products
        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $fulfillmentTypes = ['direct', 'dropshipping'];
        $reviewComments = [
            5 => [
                'Excellent product! Highly recommended.',
                'Good quality item. Fast delivery.',
                'Perfect buy, exactly like in the picture.',
                'Amazing service and very fast response on WhatsApp.',
                'Super quality. Value for money!'
            ],
            4 => [
                'Good quality item. Satisfied with the product.',
                'Nice wrapper, product is also good.',
                'Useful item, looks durable.',
                'Good purchase, fast courier service.'
            ],
            3 => [
                'Average quality. Packaging could be improved.',
                'Okay for the price.',
                'Delivery took a bit long but product is fine.'
            ],
            2 => [
                'Quality is not as expected.',
                'Not very satisfied.'
            ],
            1 => [
                'Worst purchase ever.',
                'Damaged package and bad quality.'
            ]
        ];

        $customerNames = [
            'Kamal Perera', 'Nimal Silva', 'Sunil Jayawardena', 'Priyantha Bandara', 
            'Anura Fernando', 'Chathura Gunasekara', 'Ruwan Herath', 'Ishara Perera',
            'Samanthi Ranasinghe', 'Dilini Cooray', 'Nilanthi Fernando', 'Kavindya Rodrigo'
        ];

        foreach ($products as $index => $product) {
            // Assign category
            $catIndex = $index % count($categories);
            $product->category_id = $categories[$catIndex]->id;
            $product->save();

            // Create 3-6 reviews for each product
            $reviewsCount = rand(3, 6);
            for ($i = 0; $i < $reviewsCount; $i++) {
                $rating = rand(3, 5); // mostly positive reviews
                if ($i === 0 && $index % 3 === 0) {
                    $rating = rand(1, 2); // add some lower ratings for realistic ratings
                }
                
                $commentsPool = $reviewComments[$rating];
                $comment = $commentsPool[array_rand($commentsPool)];
                $customerName = $customerNames[array_rand($customerNames)];

                ProductReview::create([
                    'product_id' => $product->id,
                    'customer_name' => $customerName,
                    'rating' => $rating,
                    'comment' => $comment,
                ]);
            }
        }
    }
}
