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
        Schema::create('program_promos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('programCode');
            $table->string('name');
            $table->string('promoCode')->unique();
            $table->string('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('consumedQty')->default(0);
            $table->double('discountPrice')->default(0);
            $table->date('validFrom')->nullable();
            $table->date('validTo')->nullable();
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
        Schema::dropIfExists('program_promos');
    }
};
