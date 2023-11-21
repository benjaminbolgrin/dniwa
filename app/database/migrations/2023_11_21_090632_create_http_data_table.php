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
        Schema::create('http_data', function (Blueprint $table) {
            $table->id();
	    $table->timestamps();
	    $table->unsignedBigInteger('domain_id')->unique();
	    $table->foreign('domain_id')->references('id')->on('domains')->cascadeOnDelete();
	    $table->decimal('response_code', $precision = 3, $scale = 0);
	    $table->string('header');
	    $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('http_data');
    }
};
