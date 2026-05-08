<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacaos', function (Blueprint $table) {
            $table->id();
            $table->date('data_vencimento');
            $table->string('tipo'); // 'entrada' ou 'saida'
            $table->decimal('valor', 15, 2);
            $table->string('descricao');
            $table->string('categoria')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
            
            // Índice para melhorar performance nas buscas por data
            $table->index(['data_vencimento', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacaos');
    }
};