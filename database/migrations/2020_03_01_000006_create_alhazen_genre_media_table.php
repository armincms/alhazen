<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlhazenGenreMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alhazen_genre_media', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable(); 


            $table->foreign('media_id')->references('id')->on('alhazen_medias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('genre_id')->references('id')->on('alhazen_genres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index(['media_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alhazen_genre_media');
    }
}
