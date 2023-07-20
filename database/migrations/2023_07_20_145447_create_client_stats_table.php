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
        Schema::create('client_stats', function (Blueprint $table) {
            $table->id();
            $table->string('instance', 255)->nullable();
            $table->string('IP', 255)->nullable();
            $table->string('browser', 255)->nullable();
            $table->text('blob')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_stats');
    }
};
