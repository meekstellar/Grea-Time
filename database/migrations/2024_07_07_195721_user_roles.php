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

        Schema::table('users', function (Blueprint $table) {
            $table->string('role',15)->nullable(true)->default('');
            $table->string('image',255)->nullable(true)->default('');
            $table->string('position',255)->nullable(true)->default('');
        });

        DB::table('users')->insert(
            array(
                'name' => 'Petro Skotar',
                'email' => 'petro.skotar.dev@gmail.com',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'password' => '$2y$12$JPkg10HFQIWfPRjgAkoWFus9nulZrHcywGI0aetbR/wHQgIeou3Fy', // admin@123
                'remember_token' => Str::random(10),
                'role' => 'manager',
                'image' => 'vendor/adminlte/dist/img/user1-128x128.jpg',
                'position' => 'Manager',
            )
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
