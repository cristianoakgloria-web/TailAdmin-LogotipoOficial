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
        Schema::create('financeiro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->string('descricao');
            $table->decimal('valor', 15, 2);
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['pendente', 'pago', 'atrasado'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro');
    }
};
