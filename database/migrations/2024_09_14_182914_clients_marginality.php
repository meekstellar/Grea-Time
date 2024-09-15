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
        Schema::create('clients_marginality', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable(true)->default(0);
            $table->integer('year')->nullable(true)->default(0);
            $table->integer('month')->nullable(true)->default(0);
            $table->float('marginality')->nullable(true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_marginality');
    }
};
