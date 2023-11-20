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
			$table->unsignedBigInteger('domain_id');
			$table->string('type', 5);
			$table->string('content');
			$table->timestamps();
			$table->index(['domain_id', 'type', 'content']);
			$table->foreign('domain_id')->references('id')->on('domains')->cascadeOnDelete();
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
