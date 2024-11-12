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
        Schema::create('employee_salary_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employee', 'employee_id')->onDelete('cascade');
            $table->decimal('working_hours', 8, 2);
            $table->decimal('sick_hours', 8, 2);
            $table->decimal('bonus', 10, 2);
            $table->decimal('total', 10, 2);
            $table->date('date_measured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_results');
    }
};
