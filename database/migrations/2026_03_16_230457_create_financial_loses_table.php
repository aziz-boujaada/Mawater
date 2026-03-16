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
        Schema::create('financial_loses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meter_id')->nullable()->constrained('meters')->nullOnDelete();
            $table->foreignId('repair_id')->nullable()->constrained('repairs')->nullOnDelete();
            $table->decimal('amount_lose', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_loses');
    }
};
