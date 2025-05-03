<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['file', 'text']);
            $table->boolean('is_required')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_requirements');
    }
};
