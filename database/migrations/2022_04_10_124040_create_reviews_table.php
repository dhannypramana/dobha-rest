<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('body');
            $table->integer('rate')->default(0);
            $table->foreignId('product_id');
            $table->foreignId('user_id');

            
            /* Nested Comment (next feature) */
            // "parentId": null,
            /* Relations with Users */
            // "name": "Sultan",
            // "username": "sultan",
            // "userId": 2,
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
