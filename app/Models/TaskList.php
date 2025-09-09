<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TaskList extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'user_id',
        'is_public', // Adicione aqui
        'share_uuid',  
        'status',       // Adicione aqui
        'published_at',// E aqui
    ];
    
    protected $casts = [
        'published_at' => 'datetime', // Adicione esta linha
    ];
    
    protected static function boot()
    {
        parent::boot();

        // Antes de criar uma nova lista, gera um UUID para ela.
        static::creating(function ($taskList) {
            if (empty($taskList->share_uuid)) {
                $taskList->share_uuid = (string) Str::uuid();
            }
        });
    }
    

    // Relação: Uma lista pertence a UM usuário.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relação: Uma lista TERÁ MUITAS tarefas. (Já estamos deixando pronto)
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}