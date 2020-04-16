<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlhazenArtistMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alhazen_artist_media', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedBigInteger('artist_id')->nullable(); 
            $table->unsignedBigInteger('role_id')->nullable(); 


            $table->foreign('media_id')->references('id')->on('alhazen_medias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('artist_id')->references('id')->on('alhazen_artists')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('role_id')->references('id')->on('alhazen_roles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index(['media_id', 'artist_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alhazen_artist_media');
    }
}
