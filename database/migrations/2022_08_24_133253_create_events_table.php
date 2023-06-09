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
        Schema::create('events', function (Blueprint $table) {
            // $table->id();
            $table->unsignedInteger('partner_id');
            $table->string('programCode')->unique();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('eventIncharge')->nullable();
            $table->date('activeUntil')->nullable();
            $table->double('price')->default('0');
            $table->string('venue')->nullable();
            $table->integer('limit')->default(0); // 0 = unlimited | >0 = limit
            $table->string('email')->nullable();
            $table->text('specialSettings')->nullable();
            $table->string('type')->default('physical'); // online | physical | hybrid
            $table->boolean('isActive')->default(1);
            $table->string('status')->default('Published'); // published | draft | approval
            $table->integer('totalRegistrants')->default(0);
            $table->string('thumbnail')->default('https://via.placeholder.com/450x300?text=Sower+Institute');
            $table->string('banner')->default('https://via.placeholder.com/650x250?text=Sower+Institute');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('events');
    }
};
