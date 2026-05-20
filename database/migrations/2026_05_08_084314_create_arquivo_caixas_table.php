<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arquivo_caixas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->string('mes');
            $table->string('ano');
            $table->string('moeda')->default('AKZ');
            $table->decimal('saldo_anterior', 15, 2)->default(0);
            $table->decimal('despesa_anterior', 15, 2)->default(0);
            $table->string('arquivo_path')->nullable(); // caminho do Excel gerado
            $table->enum('status', ['rascunho', 'finalizado', 'arquivado'])->default('rascunho');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arquivo_caixas');
    }
};