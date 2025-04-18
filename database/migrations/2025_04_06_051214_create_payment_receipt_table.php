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
        Schema::create('payment_receipt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intention_register_id')->constrained('intention_register')->onDelete('cascade');
            $table->decimal('amount_charged', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->foreignId('receipt_type_id')->constrained('receipt_type')->onDelete('cascade');
            $table->string('receipt_number')->nullable();
            $table->foreignId('payment_method_id')->constrained('payment_method')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receipt');
    }
};
