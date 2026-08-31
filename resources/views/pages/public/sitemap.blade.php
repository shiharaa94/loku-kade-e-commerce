<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Main Landing Page -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- Shop Catalog Page -->
    <url>
        <loc>{{ route('products.shop') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <!-- Flash Deals Page -->
    <url>
        <loc>{{ route('products.flashDeals') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <!-- Trending Products Page -->
    <url>
        <loc>{{ route('products.trending') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <!-- Category Pages -->
    @if(isset($categories))
    @foreach($categories as $category)
    <url>
        <loc>{{ route('products.shop') }}?category={{ $category->id }}</loc>
        <lastmod>{{ $category->updated_at ? $category->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endif
    <!-- Dynamic Product Pages -->
    @foreach($products as $product)
    <url>
        <loc>{{ route('products.publicDetails', ['id' => $product->id]) }}</loc>
        <lastmod>{{ $product->updated_at ? $product->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    <!-- Terms & Conditions -->
    <url>
        <loc>{{ route('public.terms') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>
    <!-- Privacy Policy -->
    <url>
        <loc>{{ route('public.privacy') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>
</urlset>
