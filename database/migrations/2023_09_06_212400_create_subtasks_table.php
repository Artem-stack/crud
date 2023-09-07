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
        Schema::create('subtasks', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->text('description')->nullable();
        $table->enum('status', ['todo', 'done'])->default('todo');
        $table->integer('priority')->default(1);
        $table->unsignedBigInteger('parent_id');
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};
