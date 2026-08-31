<?php

namespace App\Http\Controllers;

use App\Models\CatalogFeedback;
use App\Models\Configuration;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function publicFeaturedProducts()
    {
        $stockSummary = DB::table('stocks')
            ->select(
                'product_id',
                DB::raw('SUM(CASE WHEN quantity > 0 THEN quantity ELSE 0 END) as total_quantity'),
                DB::raw("
                    MIN(
                        CASE
                            WHEN quantity > 0 THEN
                                CASE
                                    WHEN dis_status = 1 AND discount > 0
                                        THEN GREATEST(selling_price - LEAST(discount, selling_price), 0)
                                    ELSE selling_price
                                END
                            ELSE NULL
                        END
                    ) as lowest_effective_price
                ")
            )
            ->groupBy('product_id');

        $selectFields = [
            'products.id',
            'products.product_name',
            'products.short_description',
            'products.main_image',
            'products.is_catalog_visible',
            DB::raw('COALESCE(stock_summary.total_quantity, 0) as catalog_total_quantity'),
            DB::raw('stock_summary.lowest_effective_price as catalog_lowest_price'),
        ];

        $salesSummary = DB::table('order_details')
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id');

        $selectFields[] = DB::raw('COALESCE(sales_summary.total_sales, 0) as sales_volume');

        $query = Product::query()
            ->leftJoinSub($stockSummary, 'stock_summary', function ($join) {
                $join->on('stock_summary.product_id', '=', 'products.id');
            })
            ->leftJoinSub($salesSummary, 'sales_summary', function ($join) {
                $join->on('sales_summary.product_id', '=', 'products.id');
            })
            ->select($selectFields)
            ->where('stock_summary.total_quantity', '>', 0)
            ->with(['subImages:id,product_id,image_path'])
            ->where('products.is_catalog_visible', true);

        $products = $query->orderByDesc('sales_volume')
            ->orderBy('products.product_name')
            ->limit(4)
            ->get();

        $productIds = $products->pluck('id')->all();
        $stockRowsByProduct = DB::table('stocks')
            ->select(
                'id',
                'product_id',
                'selling_price',
                'discount',
                'dis_status',
                DB::raw('SUM(quantity) as quantity')
            )
            ->where('quantity', '>', 0)
            ->whereIn('product_id', $productIds)
            ->groupBy('id', 'product_id', 'selling_price', 'discount', 'dis_status')
            ->get()
            ->groupBy('product_id');

        $reviewStats = DB::table('product_reviews')
            ->select('product_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(id) as reviews_count'))
            ->whereIn('product_id', $productIds)
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        $formatted = $products->map(function (Product $product) use ($stockRowsByProduct, $reviewStats) {
            $productStocks = collect($stockRowsByProduct->get($product->id, []));
            $totalQuantity = (int) ($product->catalog_total_quantity ?? $productStocks->sum('quantity'));

            $bestStock = $productStocks
                ->sortBy(function ($stock) {
                    $discountAmount = ((int) $stock->dis_status === 1 && (float) $stock->discount > 0)
                        ? min((float) $stock->discount, (float) $stock->selling_price)
                        : 0;

                    return max((float) $stock->selling_price - $discountAmount, 0);
                })
                ->first();

            $originalPrice = $bestStock ? (float) $bestStock->selling_price : null;
            $discountAmount = 0;
            if ($bestStock && (int) $bestStock->dis_status === 1 && (float) $bestStock->discount > 0) {
                $discountAmount = min((float) $bestStock->discount, $originalPrice);
            }

            $discountedPrice = !is_null($originalPrice)
                ? max($originalPrice - $discountAmount, 0)
                : null;

            $discountPercentage = ($originalPrice && $discountAmount > 0)
                ? (int) round(($discountAmount / $originalPrice) * 100)
                : 0;

            $images = [];
            if (!empty($product->main_image_url)) {
                $images[] = $product->main_image_url;
            }
            foreach ($product->subImages as $subImage) {
                $images[] = $subImage->image_url;
            }

            $images = array_values(array_unique($images));

            $stats = $reviewStats->get($product->id);
            $avgRating = $stats ? round((float) $stats->avg_rating, 1) : 0;
            $reviewsCount = $stats ? (int) $stats->reviews_count : 0;

            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'short_description' => $product->short_description,
                'main_image_url' => $product->main_image_url,
                'images' => $images,
                'total_quantity' => $totalQuantity,
                'price' => $originalPrice,
                'has_discount' => $discountAmount > 0,
                'discount_amount' => $discountAmount,
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'best_stock_id' => $bestStock ? $bestStock->id : null,
                'avg_rating' => $avgRating,
                'reviews_count' => $reviewsCount,
                'sales_volume' => (int) $product->sales_volume,
            ];
        });

        return response()->json($formatted, 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With'
        ]);
    }

    private function getBaseProductQuery()
    {
        $stockSummary = DB::table('stocks')
            ->select(
                'product_id',
                DB::raw('SUM(CASE WHEN quantity > 0 THEN quantity ELSE 0 END) as total_quantity'),
                DB::raw("
                    MIN(
                        CASE
                            WHEN quantity > 0 THEN
                                CASE
                                    WHEN dis_status = 1 AND discount > 0
                                        THEN GREATEST(selling_price - LEAST(discount, selling_price), 0)
                                    ELSE selling_price
                                END
                            ELSE NULL
                        END
                    ) as lowest_effective_price
                ")
            )
            ->groupBy('product_id');

        $salesSummary = DB::table('order_details')
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id');

        $selectFields = [
            'products.id',
            'products.product_name',
            'products.short_description',
            'products.main_image',
            'products.is_catalog_visible',
            'products.category_id',
            DB::raw('COALESCE(stock_summary.total_quantity, 0) as catalog_total_quantity'),
            DB::raw('stock_summary.lowest_effective_price as catalog_lowest_price'),
            DB::raw('COALESCE(sales_summary.total_sales, 0) as sales_volume'),
        ];

        return Product::query()
            ->leftJoinSub($stockSummary, 'stock_summary', function ($join) {
                $join->on('stock_summary.product_id', '=', 'products.id');
            })
            ->leftJoinSub($salesSummary, 'sales_summary', function ($join) {
                $join->on('sales_summary.product_id', '=', 'products.id');
            })
            ->select($selectFields)
            ->with(['subImages:id,product_id,image_path'])
            ->where('products.is_catalog_visible', true);
    }

    private function formatProductsCollection($productsCollection)
    {
        $productIds = $productsCollection->pluck('id')->all();
        if (empty($productIds)) {
            return collect();
        }

        $stockRowsByProduct = DB::table('stocks')
            ->select(
                'id',
                'product_id',
                'selling_price',
                'discount',
                'dis_status',
                DB::raw('SUM(quantity) as quantity')
            )
            ->whereIn('product_id', $productIds)
            ->groupBy('id', 'product_id', 'selling_price', 'discount', 'dis_status')
            ->get()
            ->groupBy('product_id');

        $reviewStats = DB::table('product_reviews')
            ->select('product_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(id) as reviews_count'))
            ->whereIn('product_id', $productIds)
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        return $productsCollection->map(function (Product $product) use ($stockRowsByProduct, $reviewStats) {
            $allProductStocks = collect($stockRowsByProduct->get($product->id, []));
            $inStockBatches = $allProductStocks->where('quantity', '>', 0);
            
            // Prefer in-stock batch for pricing, or fallback to any available stock batch
            $targetStocks = $inStockBatches->isNotEmpty() ? $inStockBatches : $allProductStocks;
            $totalQuantity = (int) ($product->catalog_total_quantity ?? $inStockBatches->sum('quantity'));

            $bestStock = $targetStocks
                ->sortBy(function ($stock) {
                    $discountAmount = ((int) $stock->dis_status === 1 && (float) $stock->discount > 0)
                        ? min((float) $stock->discount, (float) $stock->selling_price)
                        : 0;

                    return max((float) $stock->selling_price - $discountAmount, 0);
                })
                ->first();

            $originalPrice = $bestStock ? (float) $bestStock->selling_price : null;
            $discountAmount = 0;
            if ($bestStock && (int) $bestStock->dis_status === 1 && (float) $bestStock->discount > 0) {
                $discountAmount = min((float) $bestStock->discount, $originalPrice);
            }

            $discountedPrice = !is_null($originalPrice)
                ? max($originalPrice - $discountAmount, 0)
                : null;

            $discountPercentage = ($originalPrice && $discountAmount > 0)
                ? (int) round(($discountAmount / $originalPrice) * 100)
                : 0;

            $images = [];
            if (!empty($product->main_image_url)) {
                $images[] = $product->main_image_url;
            }
            foreach ($product->subImages as $subImage) {
                $images[] = $subImage->image_url;
            }

            $images = array_values(array_unique($images));

            $stats = $reviewStats->get($product->id);
            $avgRating = $stats ? round((float) $stats->avg_rating, 1) : 0;
            $reviewsCount = $stats ? (int) $stats->reviews_count : 0;

            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'short_description' => $product->short_description,
                'main_image_url' => $product->main_image_url,
                'images' => $images,
                'total_quantity' => $totalQuantity,
                'price' => $originalPrice,
                'has_discount' => $discountAmount > 0,
                'discount_amount' => $discountAmount,
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'best_stock_id' => $bestStock ? $bestStock->id : null,
                'avg_rating' => $avgRating,
                'reviews_count' => $reviewsCount,
                'sales_volume' => (int) $product->sales_volume,
            ];
        });
    }

    public function shop(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'default');
        $selectedCategory = trim((string) $request->query('category', ''));

        $baseQuery = $this->getBaseProductQuery();

        if ($search !== '') {
            $baseQuery->where(function ($builder) use ($search) {
                $builder->where('products.product_name', 'like', '%' . $search . '%')
                    ->orWhere('products.short_description', 'like', '%' . $search . '%');
            });
        }

        if ($selectedCategory !== '') {
            $catId = null;
            if (is_numeric($selectedCategory)) {
                $catId = (int) $selectedCategory;
            } else {
                $categoryModel = \App\Models\Category::where('slug', $selectedCategory)
                    ->orWhere('name', $selectedCategory)
                    ->first();
                if ($categoryModel) {
                    $catId = $categoryModel->id;
                    $selectedCategory = (string) $catId;
                }
            }

            if ($catId) {
                $baseQuery->where('products.category_id', $catId);
            }
        }

        // Accept the short desktop values and the descriptive mobile values.
        $priceDirection = match ($sort) {
            'asc', 'price_asc' => 'asc',
            'desc', 'price_desc' => 'desc',
            default => null,
        };

        if ($priceDirection) {
            $baseQuery->orderByRaw('stock_summary.lowest_effective_price IS NULL')
                ->orderBy('stock_summary.lowest_effective_price', $priceDirection)
                ->orderBy('products.product_name');
        } elseif ($sort === 'newest') {
            $baseQuery->orderByDesc('products.created_at')
                ->orderBy('products.product_name');
        } else {
            $baseQuery->orderBy('products.product_name');
        }

        $products = $baseQuery->paginate(24);
        $products->setCollection($this->formatProductsCollection($products->getCollection()));

        $products->appends([
            'q' => $search,
            'sort' => $sort,
            'category' => $selectedCategory,
        ]);

        // Carousels (Only on first page without filter/search)
        $topFlashDeals = collect();
        $topTrending = collect();

        if ($search === '' && $selectedCategory === '' && $products->currentPage() === 1) {
            // Flash Deals (Active discounts)
            $flashQuery = $this->getBaseProductQuery()
                ->whereExists(function ($sub) {
                    $sub->select(DB::raw(1))
                        ->from('stocks')
                        ->whereColumn('stocks.product_id', 'products.id')
                        ->where('stocks.quantity', '>', 0)
                        ->where('stocks.dis_status', 1)
                        ->where('stocks.discount', '>', 0);
                });
            
            $flashProducts = $flashQuery->get();
            $topFlashDeals = $this->formatProductsCollection($flashProducts)
                ->where('discount_percentage', '>', 0)
                ->sortByDesc('discount_percentage')
                ->take(10)
                ->values();

            // Trending (sales volume desc)
            $trendingQuery = $this->getBaseProductQuery()
                ->orderByDesc('sales_volume')
                ->limit(10);
            
            $trendingProducts = $trendingQuery->get();
            $topTrending = $this->formatProductsCollection($trendingProducts);
        }

        $catalogMessage = Configuration::where('key', 'catalog_message')->value('value') ?? '';
        $feedbacks = collect();
        if (Schema::hasTable('catalog_feedbacks')) {
            $feedbacks = CatalogFeedback::where('is_active', 1)
                ->orderBy('display_order')
                ->orderByDesc('created_at')
                ->get();
        }

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('pages.public.products.shop', [
            'products' => $products,
            'topFlashDeals' => $topFlashDeals,
            'topTrending' => $topTrending,
            'catalogMessage' => $catalogMessage,
            'feedbacks' => $feedbacks,
            'search' => $search,
            'sort' => $sort,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function flashDeals()
    {
        $flashQuery = $this->getBaseProductQuery()
            ->whereExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('stocks')
                    ->whereColumn('stocks.product_id', 'products.id')
                    ->where('stocks.quantity', '>', 0)
                    ->where('stocks.dis_status', 1)
                    ->where('stocks.discount', '>', 0);
            });

        $flashProducts = $flashQuery->get();
        $formatted = $this->formatProductsCollection($flashProducts)
            ->where('discount_percentage', '>', 0)
            ->sortByDesc('discount_percentage')
            ->values();

        return view('pages.public.products.flash_deals', [
            'products' => $formatted
        ]);
    }

    public function trending()
    {
        $trendingQuery = $this->getBaseProductQuery()
            ->orderByDesc('sales_volume')
            ->limit(50);

        $trendingProducts = $trendingQuery->get();
        $formatted = $this->formatProductsCollection($trendingProducts);

        return view('pages.public.products.trending', [
            'products' => $formatted
        ]);
    }

    public function publicProductDetails($id)
    {
        $product = Product::with(['subImages:id,product_id,image_path'])->findOrFail($id);

        if (!$product->is_catalog_visible) {
            abort(404);
        }

        $productStocks = DB::table('stocks')
            ->select('id', 'selling_price', 'discount', 'dis_status', DB::raw('SUM(quantity) as quantity'))
            ->where('product_id', $product->id)
            ->where('quantity', '>', 0)
            ->groupBy('id', 'selling_price', 'discount', 'dis_status')
            ->get();

        $totalQuantity = $productStocks->sum('quantity');

        $bestStock = $productStocks
            ->sortBy(function ($stock) {
                $discountAmount = ((int) $stock->dis_status === 1 && (float) $stock->discount > 0)
                    ? min((float) $stock->discount, (float) $stock->selling_price)
                    : 0;

                return max((float) $stock->selling_price - $discountAmount, 0);
            })
            ->first();

        $originalPrice = $bestStock ? (float) $bestStock->selling_price : null;
        $discountAmount = 0;
        if ($bestStock && (int) $bestStock->dis_status === 1 && (float) $bestStock->discount > 0) {
            $discountAmount = min((float) $bestStock->discount, $originalPrice);
        }

        $discountedPrice = !is_null($originalPrice)
            ? max($originalPrice - $discountAmount, 0)
            : null;

        $discountPercentage = ($originalPrice && $discountAmount > 0)
            ? (int) round(($discountAmount / $originalPrice) * 100)
            : 0;

        $images = [];
        if (!empty($product->main_image_url)) {
            $images[] = $product->main_image_url;
        }
        foreach ($product->subImages as $subImage) {
            $images[] = $subImage->image_url;
        }
        $images = array_values(array_unique($images));

        $productDetails = [
            'id' => $product->id,
            'product_name' => $product->product_name,
            'short_description' => $product->short_description,
            'main_image_url' => $product->main_image_url,
            'images' => $images,
            'total_quantity' => $totalQuantity,
            'price' => $originalPrice,
            'has_discount' => $discountAmount > 0,
            'discount_amount' => $discountAmount,
            'discount_percentage' => $discountPercentage,
            'discounted_price' => $discountedPrice,
            'youtube_video_url' => $product->youtube_video_url,
            'best_stock_id' => $bestStock ? $bestStock->id : null,
            'product_stocks' => $productStocks, // Pass all available stock tiers (if any price variants exist)
        ];

        $relatedProductsRaw = Product::query()
            ->where('id', '!=', $product->id)
            ->where('is_catalog_visible', true)
            ->with(['subImages:id,product_id,image_path'])
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $relatedProductIds = $relatedProductsRaw->pluck('id')->all();
        $relatedStockRows = DB::table('stocks')
            ->select(
                'id',
                'product_id',
                'selling_price',
                'discount',
                'dis_status',
                DB::raw('SUM(quantity) as quantity')
            )
            ->where('quantity', '>', 0)
            ->whereIn('product_id', $relatedProductIds)
            ->groupBy('id', 'product_id', 'selling_price', 'discount', 'dis_status')
            ->get()
            ->groupBy('product_id');

        $relatedProducts = $relatedProductsRaw->map(function ($relatedProduct) use ($relatedStockRows) {
            $productStocks = collect($relatedStockRows->get($relatedProduct->id, []));
            $totalQuantity = $productStocks->sum('quantity');

            $bestStock = $productStocks
                ->sortBy(function ($stock) {
                    $discountAmount = ((int) $stock->dis_status === 1 && (float) $stock->discount > 0)
                        ? min((float) $stock->discount, (float) $stock->selling_price)
                        : 0;

                    return max((float) $stock->selling_price - $discountAmount, 0);
                })
                ->first();

            $originalPrice = $bestStock ? (float) $bestStock->selling_price : null;
            $discountAmount = 0;
            if ($bestStock && (int) $bestStock->dis_status === 1 && (float) $bestStock->discount > 0) {
                $discountAmount = min((float) $bestStock->discount, $originalPrice);
            }

            $discountedPrice = !is_null($originalPrice)
                ? max($originalPrice - $discountAmount, 0)
                : null;

            $discountPercentage = ($originalPrice && $discountAmount > 0)
                ? (int) round(($discountAmount / $originalPrice) * 100)
                : 0;

            $images = [];
            if (!empty($relatedProduct->main_image_url)) {
                $images[] = $relatedProduct->main_image_url;
            }
            foreach ($relatedProduct->subImages as $subImage) {
                $images[] = $subImage->image_url;
            }
            $images = array_values(array_unique($images));

            return [
                'id' => $relatedProduct->id,
                'product_name' => $relatedProduct->product_name,
                'short_description' => $relatedProduct->short_description,
                'main_image_url' => $relatedProduct->main_image_url,
                'images' => $images,
                'total_quantity' => $totalQuantity,
                'price' => $originalPrice,
                'has_discount' => $discountAmount > 0,
                'discount_amount' => $discountAmount,
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'best_stock_id' => $bestStock ? $bestStock->id : null,
            ];
        });

        // Get shipping methods for checkout
        $shippings = \App\Models\Shipping::all();

        // Get reviews and review stats
        $reviews = $product->reviews()->orderByDesc('created_at')->get();
        $reviewsCount = $reviews->count();
        $avgRating = $reviewsCount > 0 ? round((float) $reviews->avg('rating'), 1) : 0;
        
        $ratingBreakdown = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        return view('pages.public.products.details', [
            'product' => $productDetails,
            'relatedProducts' => $relatedProducts,
            'shippings' => $shippings,
            'reviews' => $reviews,
            'reviewsCount' => $reviewsCount,
            'avgRating' => $avgRating,
            'ratingBreakdown' => $ratingBreakdown,
        ]);
    }

    public function checkout()
    {
        $shippings = \App\Models\Shipping::all();
        $bankAccounts = \App\Models\BankAccount::all();

        $user = auth()->user();
        $lastOrder = null;
        if ($user) {
            $lastOrder = \App\Models\OrderHeader::where('customer_email', $user->email)
                ->orderBy('id', 'desc')
                ->first();
        }

        $savedAddress = $user ? ($user->address ?: ($lastOrder ? $lastOrder->customer_address : '')) : '';
        $savedCity = $user ? ($user->city ?: ($lastOrder ? $lastOrder->customer_city : '')) : '';
        $savedPriMobile = $user ? ($user->pri_mobile ?: ($lastOrder ? $lastOrder->customer_pri_mobile : '')) : '';
        $savedSecMobile = $user ? ($user->sec_mobile ?: ($lastOrder ? $lastOrder->customer_sec_mobile : '')) : '';

        return view('pages.public.products.checkout', [
            'shippings'       => $shippings,
            'bankAccounts'    => $bankAccounts,
            'user'            => $user,
            'lastOrder'       => $lastOrder,
            'savedAddress'    => $savedAddress,
            'savedCity'       => $savedCity,
            'savedPriMobile'  => $savedPriMobile,
            'savedSecMobile'  => $savedSecMobile,
        ]);
    }

    public function dynamicSitemap()
    {
        $products = Product::query()
            ->select('id', 'updated_at')
            ->where('is_catalog_visible', true)
            ->orderByDesc('updated_at')
            ->get();

        return response()->view('pages.public.sitemap', [
            'products' => $products
        ])->header('Content-Type', 'text/xml');
    }

    public function storeReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = new \App\Models\ProductReview();
        $review->product_id = $product->id;
        $review->customer_name = $validated['customer_name'];
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'] ?? null;
        $review->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
                'review' => [
                    'customer_name' => $review->customer_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->diffForHumans()
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
