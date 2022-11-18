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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('TrxID')->unique();                  // auto generated transaction number in the system (Event ProgramCode + unique counting)
            $table->string('externalURL')->nullable();          // invoice url from payment gateway (For Stripe Payment => Invoice url)
            $table->string('paymentType');                      // payment type opted by customer during checkout payment
            $table->string('paymentReferenceNo')->nullable();   // Stripe transaction code | Check No.
            $table->string('approvedBy')->nullable();           // User who approved the payment
            $table->string('status')->default('Pending');       // Pending | Paid
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
};
