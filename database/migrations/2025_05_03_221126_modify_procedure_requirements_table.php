<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedure_requirements', function (Blueprint $table) {
            $table->dropForeign(['procedure_id']);
            $table->dropColumn('procedure_id');
        });
    }

    public function down(): void
    {
        Schema::table('procedure_requirements', function (Blueprint $table) {
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
        });
    }
};
