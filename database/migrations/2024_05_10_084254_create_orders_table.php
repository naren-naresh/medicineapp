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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_contact_number');
            $table->unsignedMediumInteger('address_id');
            $table->string('address');
            $table->string('address_notes')->nullable();
            $table->string('comments')->nullable();
            $table->string('total_amount');
            $table->string('discount_amount');
            $table->string('tax_amount')->nullable();
            $table->string('delivery_charges')->nullable();
            $table->string('coupon_discount_amount')->nullable();
            $table->string('final_payable_amount');
            $table->string('order_status');
            $table->dateTime('order_created_date_time');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
