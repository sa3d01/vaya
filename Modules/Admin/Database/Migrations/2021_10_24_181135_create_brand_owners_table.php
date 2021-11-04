<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_owners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->enum('os_type',['ios','android'])->nullable();
            $table->text('fcm_token')->nullable();
            $table->string('last_session_id')->nullable();
            $table->ipAddress('last_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('banned')->nullable()->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('brand_owners');
    }
}
