<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos_fiscais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatura_id')->nullable()->constrained()->nullOnDelete();
            $table->string('titulo');
            $table->string('tipo'); // fatura, recibo, declaração, etc.
            $table->string('caminho'); // path do arquivo
            $table->string('nome_original');
            $table->decimal('valor', 12, 2)->nullable();
            $table->date('data_documento');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_fiscais');
    }
};