<?php

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('image');
            $table->string('name');
            $table->string('price');
            $table->string('quantity');
            $table->json('data');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('company_information');
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
