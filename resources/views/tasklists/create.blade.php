<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Nova Lista de Plantão') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- INÍCIO DO FORMULÁRIO --}}
                    <form method="POST" action="{{ route('tasklists.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Selecione o Plantão')" />
                            
                            {{-- CAMPO DE TEXTO SUBSTITUÍDO POR ESTE SELECT --}}
                            <select id="name" name="name" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Escolha uma opção --</option>
                                <option value="Plantão Diurno" @if(old('name') == 'Plantão Diurno') selected @endif>Plantão Diurno</option>
                                <option value="Plantão Noturno" @if(old('name') == 'Plantão Noturno') selected @endif>Plantão Noturno</option>
                                <option value="Folgista" @if(old('name') == 'Folgista') selected @endif>Folgista</option>
                            </select>
                            
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Salvar Lista') }}
                            </x-primary-button>
                        </div>
                    </form>
                    {{-- FIM DO FORMULÁRIO --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>