<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->string('titulo');              // Nome do serviço / oportunidade
            $table->text('descricao')->nullable();
            $table->decimal('valor', 12, 2)->nullable();
            $table->enum('status', [
                'proposta',          // Proposta enviada
                'negociacao',        // Em negociação
                'contratado',        // Contrato assinado, aguardando execução
                'executando',        // Em execução
                'concluido',         // Concluído
                'cancelado'
            ])->default('proposta');
            $table->date('data_prevista')->nullable();    // Data prevista para fechar ou executar
            $table->date('data_inicio_execucao')->nullable();
            $table->date('data_fim_execucao')->nullable();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicos');
    }
};