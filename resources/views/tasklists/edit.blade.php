<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Mostra o nome da lista que está sendo editada no cabeçalho --}}
            {{ __('Editar Lista: ') }} {{ $tasklist->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- INÍCIO DO FORMULÁRIO DE EDIÇÃO --}}
                    <form method="POST" action="{{ route('tasklists.update', $tasklist) }}">
                        @csrf
                        @method('PATCH') {{-- Importante: Informa ao Laravel que é uma requisição de atualização --}}

                        <!-- Nome da Lista -->
                        <div>
                            <x-input-label for="name" :value="__('Nome da Lista')" />
                            <x-text-input 
                                id="name" 
                                class="block mt-1 w-full" 
                                type="text" 
                                name="name" 
                                {{-- Preenche o campo com o nome antigo ou o valor atual da lista --}}
                                :value="old('name', $tasklist->name)" 
                                required 
                                autofocus 
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Lista') }}
                            </x-primary-button>
                        </div>
                    </form>
                    {{-- FIM DO FORMULÁRIO --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>