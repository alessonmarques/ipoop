<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restroom_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // nota de 1 a 5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reviews');
    }
};
