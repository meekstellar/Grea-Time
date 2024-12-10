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
        DB::table('users')->insert(
            array(
                'name' => 'Отпуск',
                'email' => 'restday@nomail.com',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'password' => '$2y$12$JPkg10HFQIWfPRjgAkoWFus9nulZrHcywGI0aetbR/wHQgIeou3Fy', // admin@123
                'remember_token' => Str::random(10),
                'role' => 'client',
                'image' => 'vendor/adminlte/dist/img/restday.png',
                'position' => 'Rest Day',
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
