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
        Schema::create('work_detail_measures', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('work_detail_id')->constrained('work_details');
            $table->foreignId('measure_id')->constrained('measures');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_detail_measures');
    }
};
