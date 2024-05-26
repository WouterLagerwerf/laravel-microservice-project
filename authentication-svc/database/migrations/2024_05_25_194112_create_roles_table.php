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
            $table->uuid()->primary();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->uuid('user_id')->foreign('user_id')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade');
            $table->uuid('role_id')
                ->foreign('role_id')
                ->references('uuid')
                ->on('roles')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
