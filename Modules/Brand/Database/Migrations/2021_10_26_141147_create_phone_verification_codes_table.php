<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneVerificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_owner_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('phone');
            $table->unsignedInteger('activation_code');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('verified_at')->nullable();
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
        Schema::dropIfExists('phone_verification_codes');
    }
}
