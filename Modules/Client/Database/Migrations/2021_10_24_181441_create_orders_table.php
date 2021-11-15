<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('client_address_id')->nullable();
            $table->foreign('client_address_id')->references('id')->on('client_addresses');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('brand_employee_id')->nullable();
            $table->foreign('brand_employee_id')->references('id')->on('brand_employees');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->enum('created_by',['admin','client','brand'])->default('client');
            $table->unsignedBigInteger('price')->default(0);
            $table->timestamp('date')->nullable();
            $table->string('time')->nullable();
            $table->enum('status',['in_progress','completed','cancelled'])->default('in_progress');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
