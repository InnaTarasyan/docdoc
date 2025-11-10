<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('doctors', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('npi')->unique();
			$table->string('name')->nullable();
			$table->string('gender')->nullable();
			$table->string('city')->nullable();
			$table->string('state', 2)->nullable();
			$table->string('taxonomy')->nullable();
			$table->string('organization_name')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('doctors');
	}
};


