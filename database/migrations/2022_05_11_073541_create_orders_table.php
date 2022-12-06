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
            $table->integer('customer_id');
            $table->string('orderNumber')->unique();            // Unique program code concat with the registration count of the participants
            $table->string('productCode');                      // It code be Unique program code of the EVENT/COURSE/ETC.
            $table->double('price', 10, 2 )->default(0);
            $table->integer('promo_id')->nullable();
            $table->double('discount', 10, 2)->default(0);

            // To be auto fill-up after the successful payment of the transaction
            $table->string('TrxID');                            // auto generated transaction number in the system (Event ProgramCode + unique counting)
            $table->string('externalURL')->nullable();          // invoice url from payment gateway (For Stripe Payment => Invoice url)
            $table->string('paymentType');                      // payment type opted by customer during checkout payment
            $table->string('paymentReferenceNo')->nullable();   // Stripe transaction code | Check No.
            $table->string('approvedBy')->nullable();           // User who approved the payment
            $table->text('customFields')->nullable();           // Custom Fields required based on the custom fields in the Event customization
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
