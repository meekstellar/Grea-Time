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
        Schema::create('workers_clients', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->nullable(true)->default(0);
            $table->integer('client_id')->nullable(true)->default(0);
        });
        Schema::create('workers_clients_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->nullable(true)->default(0);
            $table->integer('client_id')->nullable(true)->default(0);
            $table->float('hours', 8, 2);
            $table->integer('salary')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers_clients');
        Schema::dropIfExists('workers_clients_hours');
    }
};
