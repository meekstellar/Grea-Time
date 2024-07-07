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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50)->nullable(true)->default('');
            $table->integer('position')->nullable(true)->default(0);
        });
        DB::table('roles')->insert(array('role' => 'Manager','position' => '1'));
        DB::table('roles')->insert(array('role' => 'Employee','position' => '2'));
        DB::table('roles')->insert(array('role' => 'Client','position' => '3'));

        Schema::create('users_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(true)->default(0);
            $table->integer('role_id')->nullable(true)->default(0);
        });
        DB::table('users_roles')->insert(array('user_id' => 1,'role_id' => 1));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
