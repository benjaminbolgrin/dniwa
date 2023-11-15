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
			$table->foreignId('ud_user_id')->constrained(table: 'users', indexName: 'id')->onDelete('cascade');
			$table->foreignId('ud_domain_id')->contrained(table: 'domains', indexName: 'id')->onDelete('cascade');
			$table->timestamps();
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
