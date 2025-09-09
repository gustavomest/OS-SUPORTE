<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Compartilhamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700 dark:bg-green-200 dark:text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    @forelse ($taskLists as $list)
                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="font-bold">{{ $list->name }}</span>
                                <form method="POST" action="{{ route('tasklists.toggleSharing', $list) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white uppercase rounded-md transition {{ $list->is_public ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500' }}">
                                        {{ $list->is_public ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </div>
                            @if ($list->is_public && $list->share_uuid)
                                <div class="mt-3">
                                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Link Público:</label>
                                    <input type="text" readonly value="{{ route('tasklists.public', $list->share_uuid) }}" class="w-full mt-1 bg-gray-200 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded-md shadow-sm text-sm">
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>Você não tem nenhuma lista para compartilhar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>