<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
	/**
	* Run the migrations.
	*/
	public function up(): void
	{
		Schema::create('user_domains', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('domain_id');
			$table->unique(['user_id', 'domain_id']);
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
			$table->foreign('domain_id')->references('id')->on('domains')->cascadeOnDelete();
		});
	}

	/**
	* Reverse the migrations.
	*/
	public function down(): void
	{
		Schema::dropIfExists('user_domains');
	}
};
