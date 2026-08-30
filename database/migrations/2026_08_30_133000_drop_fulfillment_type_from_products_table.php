<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to drop fulfillment_type from products table.
     */
    public function up(): void
    {
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
    }
};
