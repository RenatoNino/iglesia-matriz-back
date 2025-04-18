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
        Schema::create('intention', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intention_register_id')->constrained('intention_register')->onDelete('cascade');
            $table->date('mass_date');
            $table->foreignId('mass_schedule_id')->constrained('mass_schedule')->onDelete('cascade');
            $table->foreignId('intention_type_id')->constrained('intention_type')->onDelete('cascade');
            $table->string('person_name');
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intention');
    }
};
