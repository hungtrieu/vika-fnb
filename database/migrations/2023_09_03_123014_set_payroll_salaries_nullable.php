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
        Schema::table('payrolls', function (Blueprint $table) {
            $table->float('salary', 16, 2, true)->nullable()->change();
            $table->float('deductions', 16, 2, true)->nullable()->change();
            $table->float('net_salary', 16, 2, true)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->float('salary', 16, 2, true)->nullable();
            $table->float('deductions', 16, 2, true)->nullable();
            $table->float('net_salary', 16, 2, true)->nullable();
        });
    }
};
