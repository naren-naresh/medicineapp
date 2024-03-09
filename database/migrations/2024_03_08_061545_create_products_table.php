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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->text('thumbnail_images')->nullable();
            $table->boolean('status')->comment('1 - Active, 2 - Inactive');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->date('manufacturer_date');
            $table->date('expiry_date');
            $table->unsignedMediumInteger('delivery_type_id');
            $table->boolean('tax_include')->comment('1-yes , 0-no');
            $table->unsignedMediumInteger('tax')->nullable();
            $table->boolean('have_variation')->comment('1-yes , 0-no');
            $table->text('variation_name')->nullable();
            $table->double('retail_price');
            $table->double('selling_price');
            $table->unsignedMediumInteger('stock')->nullable();
            $table->unsignedMediumInteger('threshold_qty')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('return_policy_applicable')->comment('1-yes , 0-no');
            $table->unsignedMediumInteger('return_policy_id')->nullable();
            // $table->string('search_engine_name')->nullable();
            // $table->string('meta_title')->nullable();
            // $table->text('meta_keyword')->nullable();
            // $table->text('meta_description')->nullable();
            $table->unsignedMediumInteger('created_by');
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
        Schema::dropIfExists('products');
    }
};
