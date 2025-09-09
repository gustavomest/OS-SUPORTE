<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
   // Em app/Http/Controllers/DashboardController.php

public function index(): View
{
    // A consulta agora busca por Tarefas (O.S.) que:
    // 1. Não estão completas
    // 2. Pertencem a uma TaskList com status 'published'
    $pendingOrders = Task::query()
        ->where('is_complete', false)
        ->whereHas('taskList', function ($query) {
            $query->where('status', 'published');
        })
        ->with('taskList.user')
        ->oldest('data_hora_abertura')
        ->get();

    return view('dashboard', compact('pendingOrders'));
}
}