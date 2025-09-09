<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editando O.S: <span class="font-bold">{{ $task->ordem_servico }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PATCH') {{-- Informa ao Laravel que é uma atualização --}}
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <x-input-label for="title" value="Título / Resumo do Serviço" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="data_hora_abertura" value="Data e Hora de Abertura" />
                                <x-text-input id="data_hora_abertura" class="block mt-1 w-full" type="datetime-local" name="data_hora_abertura" :value="old('data_hora_abertura', $task->data_hora_abertura)" required />
                                <x-input-error :messages="$errors->get('data_hora_abertura')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="responsavel_abertura" value="Responsável pela Abertura" />
                                <x-text-input id="responsavel_abertura" class="block mt-1 w-full" type="text" name="responsavel_abertura" :value="old('responsavel_abertura', $task->responsavel_abertura)" required readonly />
                            </div>
                            
                            <div>
                                <x-input-label for="ordem_servico" value="Número da O.S" />
                                <x-text-input id="ordem_servico" class="block mt-1 w-full" type="text" name="ordem_servico" :value="old('ordem_servico', $task->ordem_servico)" required />
                            </div>
                            <div>
                                <x-input-label for="quadro_trabalho" value="Quadro de Trabalho" />
                                <x-text-input id="quadro_trabalho" class="block mt-1 w-full" type="text" name="quadro_trabalho" :value="old('quadro_trabalho', $task->quadro_trabalho)" required />
                            </div>
                             <div>
                                <x-input-label for="tipo" value="Tipo de Atendimento" />
                                <select id="tipo" name="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="Preventiva" @if(old('tipo', $task->tipo) == 'Preventiva') selected @endif>Manutenção Preventiva</option>
                                    <option value="Corretiva" @if(old('tipo', $task->tipo) == 'Corretiva') selected @endif>Manutenção Corretiva</option>
                                    <option value="Instalacao" @if(old('tipo', $task->tipo) == 'Instalacao') selected @endif>Instalação</option>
                                    <option value="Suporte" @if(old('tipo', $task->tipo) == 'Suporte') selected @endif>Suporte Técnico</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tecnico_id" value="Técnico Designado" />
                                <select id="tecnico_id" name="tecnico_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    {{-- Lógica para listar técnicos --}}
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="equipamento" value="Equipamento" />
                                <x-text-input id="equipamento" class="block mt-1 w-full" type="text" name="equipamento" :value="old('equipamento', $task->equipamento)" required />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="local" value="Local da Ocorrência" />
                                <x-text-input id="local" class="block mt-1 w-full" type="text" name="local" :value="old('local', $task->local)" required />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="erro_relatado" value="Erro Relatado" />
                                <textarea id="erro_relatado" name="erro_relatado" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('erro_relatado', $task->erro_relatado) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="observacoes" value="Observações" />
                                <textarea id="observacoes" name="observacoes" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('observacoes', $task->observacoes) }}</textarea>
                            </div>

                            <div class="md:col-span-2 block mt-4">
                                <label for="is_complete" class="inline-flex items-center">
                                    <input id="is_complete" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="is_complete"
                                        @if(old('is_complete', $task->is_complete)) checked @endif>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Marcar como Concluído') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tasklists.show', $task->taskList) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar O.S.') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>