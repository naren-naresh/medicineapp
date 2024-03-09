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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->double('retail_price');
            $table->double('selling_price');
            $table->unsignedMediumInteger('stock')->nullable();
            $table->unsignedMediumInteger('threshold_qty')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('status')->comment('1 - Active, 2 - Inactive');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
