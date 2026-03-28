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
        
        // Step 2: Drop old FK and add new one
       
        Schema::table('invoices', function (Blueprint $table) {
           
            Schema::table('invoices', function (Blueprint $table) {
               $table->unsignedBigInteger('reading_id')->nullable();
           });

            $table->foreign('reading_id')
                ->references('id')
                ->on('meter_readings')
                ->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
};
