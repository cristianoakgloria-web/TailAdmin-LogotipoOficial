<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('restrict');
            $table->string('numero_fatura')->unique();
            $table->date('data_emissao');
            $table->date('data_vencimento');
            $table->decimal('valor_total', 12, 2);
            $table->enum('status', ['pendente', 'parcial', 'paga', 'cancelada'])->default('pendente');
            $table->enum('tipo', ['servico', 'consultoria', 'campanha', 'outro'])->default('servico');
            $table->text('descricao')->nullable();
            $table->foreignId('servico_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faturas');
    }
};