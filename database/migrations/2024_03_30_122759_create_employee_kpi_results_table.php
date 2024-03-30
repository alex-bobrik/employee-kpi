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
        Schema::create('employee_kpi_results', function (Blueprint $table) {
            $table->id('result_id');
            $table->foreignId('employee_id')->constrained('employee', 'employee_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('kpi_id')->constrained('kpis', 'kpi_id')->onDelete('cascade');
            $table->decimal('value', 8, 2);
            $table->date('date_measured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_kpi_results');
    }
};
