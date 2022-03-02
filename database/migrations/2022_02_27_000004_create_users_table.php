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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('country');
            $table->unsignedBigInteger('gardener_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->onDelete('cascade');

            $table->foreign('gardener_id')
                ->references('id')->on('gardeners')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
