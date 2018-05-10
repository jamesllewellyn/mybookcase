<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShelfBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelf_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shelf_id');
            $table->string('isbn')->nullable();
            $table->string('isbn_13')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('shelf_id')->references('id')->on('shelves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shelf_books');
        Schema::enableForeignKeyConstraints();
    }
}
