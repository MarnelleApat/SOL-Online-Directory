<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nirc', 15)->nullable();
            $table->string('email')->unique();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('phoneNumber', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postalCode', 20)->nullable();
            $table->string('country')->nullable();
            $table->string('church')->nullable();
            $table->string('billingAddress')->nullable();
            $table->string('shippingAddress')->nullable();
            $table->string('gender')->nullable();
            $table->text('meta_data')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
