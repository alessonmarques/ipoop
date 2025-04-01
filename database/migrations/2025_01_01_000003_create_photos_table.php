<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restroom_id')->constrained()->onDelete('cascade');
            $table->string('path'); // caminho do arquivo da imagem
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('photos');
    }
};
