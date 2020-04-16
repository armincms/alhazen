<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateAlhazenArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alhazen_artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("fullname");
            $table->string("stagename");  
            $table->string('biography', 500)->nullable();   
            $table->enum("gender", Common::genders()->keys()->all())->default('male');
            $table->json('profile')->default('[]');
            $table->unsignedBigInteger('residence_id')->nullalbe();
            $table->unsignedBigInteger('birthplace_id')->nullalbe(); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('residence_id')->references('id')->on('locations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('birthplace_id')->references('id')->on('locations')
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
        Schema::dropIfExists('alhazen_artists');
    }
}
