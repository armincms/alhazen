<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlhazenMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alhazen_medias', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->enum("group", ['movie', 'series', 'episode'])->default('movie');
            $table->string("label")->nullable();  
            $table->string('story', 500)->nullable();
            $table->abstract();    

            $table->json("names")->default("[]");
            $table->json("links")->default("[]");
            $table->json("detail")->default("[]");  

            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->timestamp("release_date"); 
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('media_id')->references('id')->on('alhazen_medias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('company_id')->references('id')->on('alhazen_companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alhazen_medias');
    }
}
