<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('company_information_id');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('company_information_id')->references('id')->on('company_information');
        });
    }

    public function down(): void
    {
        Schema::table('department_companies', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['company_information_id']);
        });

        Schema::dropIfExists('department_companies');
    }
};
