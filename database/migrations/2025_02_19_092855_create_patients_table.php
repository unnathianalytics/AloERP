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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 55);
            $table->string('address', 255)->nullable();
            $table->string('mobile', 10)->nullable();
            //For Patient Columns
            $table->string('op_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('referred_by', 55)->nullable();
            $table->tinyText('image')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
