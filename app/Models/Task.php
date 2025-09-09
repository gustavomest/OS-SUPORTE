<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_complete',
        'task_list_id',
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
    ];

    // Relação: Uma tarefa pertence a UMA lista.
    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class);
    }
}