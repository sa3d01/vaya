<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_owner_id')->nullable();
            $table->foreign('brand_owner_id')->references('id')->on('brand_owners');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('commercial_num')->nullable();
            $table->timestamp('start_contract')->nullable();
            $table->timestamp('end_contract')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('insta')->nullable();
            $table->string('twitter')->nullable();
            $table->string('snap')->nullable();
            $table->boolean('banned')->nullable()->default(false);
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
        Schema::dropIfExists('brands');
    }
}
