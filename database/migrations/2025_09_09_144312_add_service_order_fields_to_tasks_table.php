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
        Schema::table('tasks', function (Blueprint $table) {
            // Renomeia o 'title' para algo mais genérico se necessário, ou mantém.
            // $table->renameColumn('title', 'descricao_servico');

            // Adiciona os novos campos após a coluna 'task_list_id'
            $table->dateTime('data_hora_abertura')->after('task_list_id')->nullable();
            $table->string('responsavel_abertura')->after('data_hora_abertura')->nullable();
            $table->string('ordem_servico')->after('responsavel_abertura')->nullable()->unique();
            $table->string('quadro_trabalho')->after('ordem_servico')->nullable();
            $table->string('tipo')->after('quadro_trabalho')->nullable();
            $table->foreignId('tecnico_id')->after('tipo')->nullable()->constrained('users');
            $table->string('equipamento')->after('tecnico_id')->nullable();
            $table->string('local')->after('equipamento')->nullable();
            $table->text('erro_relatado')->after('local')->nullable();
            $table->string('responsavel_fechamento')->after('erro_relatado')->nullable();
            $table->string('responsavel_avaliacao')->after('responsavel_fechamento')->nullable();
            $table->text('observacoes')->after('responsavel_avaliacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Remove as colunas se a migration for revertida (rollback)
            $table->dropColumn([
                'data_hora_abertura',
                'responsavel_abertura',
                'ordem_servico',
                'quadro_trabalho',
                'tipo',
                'tecnico_id',
                'equipamento',
                'local',
                'erro_relatado',
                'responsavel_fechamento',
                'responsavel_avaliacao',
                'observacoes',
            ]);
        });
    }
};