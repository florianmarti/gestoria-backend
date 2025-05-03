<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['automotor', 'impositivo', 'otros']);
            $table->text('description')->nullable();
            $table->decimal('fee', 10, 2);
            $table->integer('estimated_days');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
