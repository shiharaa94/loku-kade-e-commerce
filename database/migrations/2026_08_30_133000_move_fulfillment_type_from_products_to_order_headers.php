<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add fulfillment_type to order_headers if it doesn't already exist
        if (Schema::hasTable('order_headers') && !Schema::hasColumn('order_headers', 'fulfillment_type')) {
            Schema::table('order_headers', function (Blueprint $table) {
                $table->string('fulfillment_type')->default('direct')->after('shipping_type');
            });
        }

        // 2. Safely drop fulfillment_type from products table if it exists
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'fulfillment_type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('fulfillment_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'fulfillment_type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('fulfillment_type')->default('direct')->after('is_catalog_visible');
            });
        }

        if (Schema::hasTable('order_headers') && Schema::hasColumn('order_headers', 'fulfillment_type')) {
            Schema::table('order_headers', function (Blueprint $table) {
                $table->dropColumn('fulfillment_type');
            });
        }
    }
};
