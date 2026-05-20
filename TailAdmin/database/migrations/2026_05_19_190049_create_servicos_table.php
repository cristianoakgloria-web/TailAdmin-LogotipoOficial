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
            $table->string('titulo');              // Ex: "Campanha Instagram", "Consultoria SEO", "Gestão de Redes"
            $table->text('descricao')->nullable();
            $table->decimal('valor', 12, 2)->nullable();
            $table->enum('status', [
                'proposta',          // Proposta enviada
                'negociacao',        // Em negociação
                'contratado',        // Contrato assinado
                'em_andamento',      // Em execução
                'concluido',         // Concluído
                'cancelado'
            ])->default('proposta');
            $table->date('data_prevista')->nullable();     // Previsão de fechamento ou entrega
            $table->date('data_inicio')->nullable();       // Início da execução
            $table->date('data_fim')->nullable();          // Término da execução
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('observacoes')->nullable();       // Observações internas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicos');
    }
};