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
        Schema::create('intention_register', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_by')->constrained('user')->onDelete('cascade');
            $table->string('client_name')->nullable();
            $table->string('client_phone')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intention_register');
    }
};
