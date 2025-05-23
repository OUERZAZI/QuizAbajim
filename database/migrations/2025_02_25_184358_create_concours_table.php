<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('material_id');
            $table->string('title'); // Concours Title
            $table->text('description')->nullable();
            $table->year('start_year')->nullable(); // Concours Start Year
            $table->year('end_year')->nullable(); // Concours End Year
            $table->string('pdf_path_url')->nullable(); // PDF Path URL
            $table->string('pdf_path_url_enfant')->nullable();
            $table->string('tree_d_path_enfant')->nullable();
            $table->string('tree_d_path')->nullable(); // Replace 'column_name' with the actual column after which you want to place it
            $table->string('image_cover_path')->nullable(); // Image Cover Path
            $table->integer('total_icon')->default(0);

            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade'); // Foreign key to Material
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concours');
    }
}
