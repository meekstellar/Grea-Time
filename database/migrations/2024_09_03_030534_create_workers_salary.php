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
        Schema::create('workers_salary', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->nullable(true)->default(0);
            $table->integer('year')->nullable(true)->default(0);
            $table->integer('month')->nullable(true)->default(0);
            $table->integer('salary')->nullable(true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers_salary');
    }
};
