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
		Schema::create('dns_records', function (Blueprint $table) {
			$table->id();
			$table->foreignId('dr_domain_id')->constrained(table: 'domains', indexName: 'id')->onDelete('cascade');
			$table->string('type', 5);
			$table->string('content');
			$table->timestamps();
		});
	}

	/**
	* Reverse the migrations.
	*/
	public function down(): void
	{
		Schema::dropIfExists('dns_records');
	}
};
