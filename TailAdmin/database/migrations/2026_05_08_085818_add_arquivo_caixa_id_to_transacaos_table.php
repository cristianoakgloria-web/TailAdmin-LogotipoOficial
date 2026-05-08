<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->foreignId('arquivo_caixa_id')->nullable()->after('id')->constrained('arquivo_caixas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->dropForeign(['arquivo_caixa_id']);
            $table->dropColumn('arquivo_caixa_id');
        });
    }
};