<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class TaskListController extends Controller
{
    public function publishForShift(TaskList $tasklist): RedirectResponse
    {
        // Garante que o usuário só possa publicar suas próprias listas
        abort_if($tasklist->user_id !== Auth::id(), 403);

        // Se a lista já está publicada, não faz nada
        if ($tasklist->status === 'published') {
            return back()->with('info', 'Esta lista já foi publicada.');
        }

        $tasklist->status = 'published';
        $tasklist->published_at = Carbon::now(); // Registra a data e hora da publicação
        $tasklist->save();

        return back()->with('success', 'Lista publicada para o próximo plantão com sucesso!');
    }
    
   // DEPOIS
public function showPublished(): View
{
    $publishedLists = TaskList::where('status', 'published')
        ->with(['user', 'tasks']) // Carrega o usuário E as tarefas da lista
        ->latest('published_at')
        ->get();

    return view('tasklists.published', compact('publishedLists'));
}

    /**
     * Ativa ou desativa o compartilhamento de uma lista.
     */
    public function toggleSharing(TaskList $tasklist): RedirectResponse
    {
        // Garante que o usuário só possa alterar suas próprias listas
        abort_if($tasklist->user_id !== Auth::id(), 403);

        // Inverte o valor booleano (se for true, vira false, e vice-versa)
        $tasklist->is_public = !$tasklist->is_public;
        $tasklist->save();

        $message = $tasklist->is_public ? 'Compartilhamento ativado!' : 'Compartilhamento desativado.';

        return back()->with('success', $message);
    }

    /**
     * Mostra a página pública de uma lista compartilhada.
     */
    public function showPublic(string $uuid): View
    {
        // Busca a lista pelo UUID e SÓ SE ela estiver marcada como pública
        $taskList = TaskList::where('share_uuid', $uuid)->where('is_public', true)->firstOrFail();

        // Carrega as tarefas da lista
        $tasks = $taskList->tasks()->latest()->get();

        return view('tasklists.public', compact('taskList', 'tasks'));
    }
    /**
     * Display a listing of the resource for the authenticated user.
     */
    public function index(): View
    {
        // Pega as listas de tarefas que pertencem APENAS ao usuário logado,
        // ordenadas da mais recente para a mais antiga.
        $taskLists = Auth::user()->taskLists()->latest()->get();

        return view('tasklists.index', compact('taskLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Cria a lista de tarefas associada ao usuário logado.
        $request->user()->taskLists()->create($validated);

        return redirect()->route('tasklists.index')->with('success', 'Lista criada com sucesso!');
    }




public function show(TaskList $tasklist): View
{
    
    abort_if($tasklist->user_id !== Auth::id() && $tasklist->status !== 'published', 403);
    
   
    $tasks = $tasklist->tasks()->latest('data_hora_abertura')->get();

    return view('tasklists.show', compact('tasklist', 'tasks'));
}

    
    public function edit(TaskList $tasklist): View
    {
        
        abort_if($tasklist->user_id !== Auth::id(), 403);

        return view('tasklists.edit', compact('tasklist'));
    }

    public function shareManagement(): View
    {
        $taskLists = Auth::user()->taskLists()->latest()->get();
        return view('tasklists.share-management', compact('taskLists'));
    }


    public function update(Request $request, TaskList $tasklist): RedirectResponse
    {
        // Medida de segurança: Garante que o usuário só possa atualizar suas próprias listas.
        abort_if($tasklist->user_id !== Auth::id(), 403);

        // Valida o novo nome.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Atualiza a lista com os dados validados.
        $tasklist->update($validated);

        return redirect()->route('tasklists.index')->with('success', 'Lista atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $tasklist): RedirectResponse
    {
        // Medida de segurança: Garante que o usuário só possa deletar suas próprias listas.
        abort_if($tasklist->user_id !== Auth::id(), 403);

        $tasklist->delete();

        return redirect()->route('tasklists.index')->with('success', 'Lista deletada com sucesso!');
    }
    
}