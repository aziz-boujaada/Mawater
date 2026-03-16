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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meter_id')->nullable()->constrained('meters')->nullOnDelete();
            $table->foreignId('repair_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('problem_description');
            $table->decimal('repair_cost', 10, 2);
            $table->date('repair_date');
            $table->enum('status', ['in progress', 'repaired']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
