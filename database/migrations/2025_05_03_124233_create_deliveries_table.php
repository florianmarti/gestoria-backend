<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_procedure_id')->constrained()->onDelete('cascade');
            $table->enum('delivery_type', ['email', 'physical']);
            $table->text('address')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered'])->default('pending');
            $table->string('tracking_code', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
