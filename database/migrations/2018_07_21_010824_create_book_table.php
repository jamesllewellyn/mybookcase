<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('authors');
            $table->string('image')->nullable();
            $table->string('isbn');
            $table->string('isbn_13')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('shelf_books', function (Blueprint $table) {
            $table->dropColumn('isbn');
            $table->dropColumn('isbn_13');
            $table->unsignedInteger('book_id')->after('shelf_id');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');

        Schema::table('shelf_books', function (Blueprint $table) {
            $table->dropColumn('book_id');
            $table->string('isbn')->nullable();
            $table->string('isbn_13')->nullable();
        });
    }
}
