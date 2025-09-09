<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Histórico de Plantões Publicados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    @forelse ($publishedLists as $list)
                        <a href="{{ route('tasklists.show', $list) }}" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <div class="flex justify-between items-center">
                                <h3 class="font-bold text-lg">{{ $list->name }}</h3>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $list->published_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Publicado por: <span class="font-semibold">{{ $list->user->name }}</span>
                            </p>
                        </a>
                    @empty
                        <p>Nenhuma lista de plantão foi publicada ainda.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>