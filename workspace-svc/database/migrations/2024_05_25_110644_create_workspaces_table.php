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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name');
            $table->string('endpoint')->unique();
            $table->boolean('product_schema_created')->default(false);
            $table->boolean('auth_schema_created')->default(false);
            $table->boolean('order_schema_created')->default(false);
            $table->boolean('search_schema_created')->default(false);
            $table->boolean('notify_schema_created')->default(false);
            $table->boolean('connect_account_created')->default(false);
            $table->text('password_client_id')->nullable();
            $table->text('password_client_secret')->nullable();
            $table->text('machine_to_machine_client_id')->nullable();
            $table->text('machine_to_machine_client_secret')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
