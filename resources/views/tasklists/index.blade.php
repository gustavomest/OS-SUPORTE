<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Minhas Listas de Tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- MOSTRAR MENSAGEM DE SUCESSO --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700 dark:bg-green-200 dark:text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- BOTÃO "CRIAR NOVA LISTA" (ESTILO ATUALIZADO) --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('tasklists.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Criar Nova Lista') }}
                        </a>
                    </div>

                    {{-- INÍCIO DA LISTAGEM DE TAREFAS --}}
{{-- INÍCIO DA LISTAGEM DE TAREFAS (CORRIGIDO) --}}
<div class="space-y-4">
    @forelse ($taskLists as $list)
        <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <div>
                <a href="{{ route('tasklists.show', $list) }}" class="font-semibold text-lg hover:text-blue-500 dark:hover:text-blue-400">{{ $list->name }} </a>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Criada por: {{ $list->user->name }} em {{ $list->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="flex items-center space-x-2">

                {{-- NOVO BOTÃO PARA PUBLICAR O PLANTÃO --}}
                @if ($list->status === 'active')
                    <form method="POST" action="{{ route('tasklists.publish', $list) }}" onsubmit="return confirm('Após publicar, você não poderá mais editar esta lista. Deseja continuar?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" title="Publicar Plantão" class="inline-flex items-center justify-center p-2 bg-orange-500 border border-transparent rounded-md text-white hover:bg-orange-600 active:bg-orange-700 transition ease-in-out duration-150">
                            <span class="sr-only">Publicar Plantão</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </button>
                    </form>
                @endif
                
                {{-- BOTÃO DE EDITAR --}}
                <a href="{{ route('tasklists.edit', $list) }}" title="Editar" class="inline-flex items-center justify-center p-2 bg-gray-600 border border-transparent rounded-md text-white hover:bg-gray-700 active:bg-gray-800 transition ease-in-out duration-150">
                    <span class="sr-only">Editar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                </a>

                {{-- BOTÃO DE EXCLUIR --}}
                <form method="POST" action="{{ route('tasklists.destroy', $list) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta lista?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Excluir" class="inline-flex items-center justify-center p-2 bg-red-600 border border-transparent rounded-md text-white hover:bg-red-700 active:bg-red-800 transition ease-in-out duration-150">
                        <span class="sr-only">Excluir</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-4">
            <p>Você ainda não criou nenhuma lista de tarefas.</p>
        </div>
    @endforelse
</div>
{{-- FIM DA LISTAGEM DE TAREFAS --}}
                    </div>
                    {{-- FIM DA LISTAGEM DE TAREFAS --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>