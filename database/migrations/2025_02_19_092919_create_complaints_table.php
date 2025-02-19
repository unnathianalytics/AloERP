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
        Schema::create('complaints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');

            $table->string('case_no')->unique();
            $table->date('case_date');
            $table->string('case_detail');
            $table->string('medication');
            $table->string('lab_reports')->nullable();
            $table->string('uploads')->nullable();

            $table->unsignedBigInteger('user')->default(1);
            $table->timestamps();
            $table->foreign(columns: 'patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
