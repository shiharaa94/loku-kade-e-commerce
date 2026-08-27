<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_headers', function (Blueprint $table) {
            $table->string('secure_token', 64)->nullable()->unique()->after('order_number');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->string('order_number', 64)->nullable()->after('product_id');
            $table->index('order_number');
        });

        // Generate tokens for existing orders
        $orders = DB::table('order_headers')->whereNull('secure_token')->get();
        foreach ($orders as $order) {
            DB::table('order_headers')
                ->where('order_number', $order->order_number)
                ->update([
                    'secure_token' => Str::random(32)
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_headers', function (Blueprint $table) {
            $table->dropColumn('secure_token');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex(['order_number']);
            $table->dropColumn('order_number');
        });
    }
};
