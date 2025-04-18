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
        Schema::create('receipt_number_sequence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_type_id')->constrained('receipt_type')->onDelete('cascade');
            $table->string('prefix');
            $table->unsignedBigInteger('last_receipt_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_number_sequence');
    }
};
