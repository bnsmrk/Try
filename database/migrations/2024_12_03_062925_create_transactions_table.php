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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('item_no')->nullable();
            $table->string('control_no')->nullable();
            $table->string('party_represented')->nullable();
            $table->string('gender')->nullable();
            $table->string('title_of_case')->nullable();
            $table->string('court_body')->nullable();
            $table->string('case_type')->nullable();
            $table->string('case_no')->nullable();
            $table->string('last_action_taken')->nullable();
            $table->string('status')->nullable();
            $table->string('case_received')->nullable();
            $table->string('date_of_termination')->nullable();
            $table->string('cause_of_action')->nullable();
            $table->string('cause_of_termination')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
