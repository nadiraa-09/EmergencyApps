<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('areaId')->constrained('areas')->cascadeOnDelete();
            $table->string('createdBy')->nullable();
            $table->string('updatedBy')->nullable();
            $table->timestamps(); // otomatis buat created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
