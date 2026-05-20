<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatura_id')->constrained()->onDelete('cascade');
            $table->decimal('valor', 12, 2);
            $table->date('data_pagamento');
            $table->enum('metodo', ['dinheiro', 'transferencia', 'deposito', 'cheque', 'outro'])->default('transferencia');
            $table->string('referencia')->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
};