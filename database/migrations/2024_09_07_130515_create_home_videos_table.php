<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre',200);
            $table->text('video');
            $table->integer('page')->nullable();
            $table->string('description',200);
            $table->integer('numero')->nullable();
            $table->unsignedInteger('manuel_id');
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
        Schema::dropIfExists('home_videos');
    }
}
