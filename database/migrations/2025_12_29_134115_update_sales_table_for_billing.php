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
            $table->string('order_number')->nullable()->after('id')->unique();
            $table->decimal('tax', 10, 2)->default(0)->after('total');
            $table->decimal('discount', 10, 2)->default(0)->after('tax');
            $table->decimal('grand_total', 10, 2)->default(0)->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['order_number', 'tax', 'discount', 'grand_total']);
        });
    }
};
