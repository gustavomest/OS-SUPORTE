<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Adicione esta importação
use Illuminate\Support\Facades\Auth;    // Adicione esta importação

class DashboardController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Remove o usuário especificado do banco de dados.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Regra de segurança CRÍTICA: Impedir que um admin se auto-delete.
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode excluir sua própria conta de administrador!');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Usuário excluído com sucesso.');
    }
}