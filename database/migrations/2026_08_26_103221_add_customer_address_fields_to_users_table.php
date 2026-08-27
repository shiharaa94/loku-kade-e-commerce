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
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('email');
            $table->string('city', 255)->nullable()->after('address');
            $table->string('pri_mobile', 50)->nullable()->after('city');
            $table->string('sec_mobile', 50)->nullable()->after('pri_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'city', 'pri_mobile', 'sec_mobile']);
        });
    }
};
