<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('html_meta_data', function (Blueprint $table) {
            $table->id();
	    $table->unsignedBigInteger('http_data_id');
	    $table->string('meta_name');
	    $table->string('meta_content');
	    $table->string('meta_charset');
	    $table->string('meta_http_equiv');
	    $table->string('meta_property');
	    $table->string('meta_itemprop');
	    $table->timestamps();
	    $table->foreign('http_data_id')->references('id')->on('http_data')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('html_meta_data');
    }
};
