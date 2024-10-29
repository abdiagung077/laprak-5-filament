<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // string
            $table->integer('quantity'); // integer
            $table->boolean('is_available'); // Boolean
            $table->string('image')->nullable(); // gambar
            $table->string('file')->nullable(); // file
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // relasi ke kategori
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
