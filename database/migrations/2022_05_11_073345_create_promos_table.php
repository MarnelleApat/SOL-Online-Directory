<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id');
            $table->string('name');
            $table->string('promoCode')->unique();
            $table->string('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('consumedQty')->default(0);
            $table->double('discountPrice')->default(0);
            $table->date('validFrom')->nullable();
            $table->date('validTo')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
};
