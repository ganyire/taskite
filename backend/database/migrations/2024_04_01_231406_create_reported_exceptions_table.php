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
        Schema::create('reported_exceptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('exception_message');
            $table->string('file');
            $table->unsignedInteger('line');
            $table->text('exception_trace');
            $table->string('exception_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_exceptions');
    }
};
