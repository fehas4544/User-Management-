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
        Schema::table('sales', function (Blueprint $table) {
            // Check if columns exist before dropping them
            if (Schema::hasColumn('sales', 'product_name')) {
                $table->dropColumn('product_name');
            }
            if (Schema::hasColumn('sales', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('sales', 'price')) {
                $table->dropColumn('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('product_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
        });
    }
};
