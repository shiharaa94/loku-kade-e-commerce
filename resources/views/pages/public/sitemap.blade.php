<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Main Landing Page -->
    <url>
        <loc>https://lokukade.lk/</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- Terms & Conditions -->
    <url>
        <loc>https://lokukade.lk/terms</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <!-- Privacy Policy -->
    <url>
        <loc>https://lokukade.lk/privacy</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <!-- Catalog Page -->
    <url>
        <loc>https://lokukade.lk/catalog</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <!-- Dynamic Product Pages -->
    @foreach($products as $product)
    <url>
        <loc>https://lokukade.lk/catalog/product/{{ $product->id }}</loc>
        <lastmod>{{ $product->updated_at ? $product->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
