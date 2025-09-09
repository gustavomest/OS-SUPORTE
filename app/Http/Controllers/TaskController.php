<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new task within a list.
     */
    public function create(TaskList $tasklist): View
{
    abort_if($tasklist->user_id !== Auth::id(), 403);
    
    // Busca todos os usuários para listar como técnicos
    $technicians = User::orderBy('name')->get();

    return view('tasks.create', compact('tasklist', 'technicians'));
}

    /**
     * Store a newly created task in storage.
     */
    // No TaskController.php

public function store(Request $request, TaskList $tasklist): RedirectResponse
{
    // Garante que o usuário só possa adicionar tarefas em suas próprias listas.
    abort_if($tasklist->user_id !== Auth::id(), 403);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'data_hora_abertura' => 'required|date',
        'responsavel_abertura' => 'required|string|max:255',
        'ordem_servico' => 'required|string|max:255|unique:tasks,ordem_servico',
        'quadro_trabalho' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'tecnico_id' => 'nullable|exists:users,id',
        'equipamento' => 'required|string|max:255',
        'local' => 'required|string|max:255',
        'erro_relatado' => 'required|string',
        'observacoes' => 'nullable|string',
    ]);

    // Usa o relacionamento para criar a tarefa, associando-a automaticamente à lista.
    $tasklist->tasks()->create($validated);

    return redirect()->route('tasklists.show', $tasklist)->with('success', 'Ordem de Serviço criada com sucesso!');
}


    /**
     * Show the form for editing the specified task.
     * Note: A rota é 'shallow', então não precisamos do $tasklist aqui.
     */
    public function edit(Task $task): View
{
    abort_if($task->taskList->user_id !== Auth::id(), 403);
    
    // Busca todos os usuários para listar como técnicos
    $technicians = User::orderBy('name')->get();
        
    return view('tasks.edit', compact('task', 'technicians'));
}

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        // Garante que o usuário só possa atualizar tarefas de suas próprias listas.
        abort_if($task->taskList->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->update($validated);

        // Lógica para o checkbox de conclusão
        $task->is_complete = $request->has('is_complete');
        $task->save();

        return redirect()->route('tasklists.show', $task->taskList)->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        // Garante que o usuário só possa deletar tarefas de suas próprias listas.
        abort_if($task->taskList->user_id !== Auth::id(), 403);

        $task->delete();

        return redirect()->route('tasklists.show', $task->taskList)->with('success', 'Tarefa excluída com sucesso!');
    }
}