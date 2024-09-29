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
        Schema::create('lost_pets', function (Blueprint $table) {
            $table->id();
            $table->enum('species', ['dog', 'cat', 'bird','rabbit','guinea pig','other']);
            $table->string('breed')->nullable();
            $table->integer('years')->nullable();
            $table->integer('months')->nullable();
            $table->string('location');
            $table->enum('gender', ['male', 'female']);
            $table->text('description');
            $table->string('image');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
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
        Schema::dropIfExists('lost_pets');
    }
};
