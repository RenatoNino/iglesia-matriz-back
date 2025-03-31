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
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->references('id')
                ->on('person')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('reset_password_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('avatar')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->references('id')
                ->on('role')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->references('id')
                ->on('user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')
                ->nullable()
                ->references('id')
                ->on('option')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('menu_id')
                ->references('id')
                ->on('menu')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('name_url');
            $table->string('icon')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('role_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->references('id')
                ->on('role')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('option_id')
                ->references('id')
                ->on('option')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_option');
        Schema::dropIfExists('option');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('role');
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
