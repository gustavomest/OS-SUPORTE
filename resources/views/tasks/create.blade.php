<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Abrir Nova O.S. na Lista: <span class="font-bold">{{ $tasklist->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tasklists.tasks.store', $tasklist) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <x-input-label for="title" value="Número da O.S" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                            </div>

                            <div>
                                <x-input-label for="data_hora_abertura" value="Data e Hora de Abertura" />
                                <x-text-input id="data_hora_abertura" class="block mt-1 w-full" type="datetime-local" name="data_hora_abertura" required />
                            </div>

                            <div>
                                <x-input-label for="responsavel_abertura" value="Responsável pela Abertura" />
                                <x-text-input id="responsavel_abertura" class="block mt-1 w-full" type="text" name="responsavel_abertura" :value="Auth::user()->name" required readonly />
                            </div>

                            <div>
                                <x-input-label for="ordem_servico" value="Número da O.S" />
                                <x-text-input id="ordem_servico" class="block mt-1 w-full" type="text" name="ordem_servico" required />
                            </div>

                            <div>
                                <x-input-label for="quadro_trabalho" value="Quadro de Trabalho" />
                                <x-text-input id="quadro_trabalho" class="block mt-1 w-full" type="text" name="quadro_trabalho" required />
                            </div>

                            <div>
                                <x-input-label for="tipo" value="Tipo de Atendimento" />
                                <select id="tipo" name="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Preventiva">Manutenção Preventiva</option>
                                    <option value="Corretiva">Manutenção Corretiva</option>
                                    <option value="Instalacao">Instalação</option>
                                    <option value="Suporte">Suporte Técnico</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="tecnico_id" value="Técnico Designado" />
                                <select id="tecnico_id" name="tecnico_id" class="...">
    <option value="">-- Selecione um técnico --</option>
    @foreach ($technicians as $technician)
        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
    @endforeach
</select>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="equipamento" value="Equipamento" />
                                <x-text-input id="equipamento" class="block mt-1 w-full" type="text" name="equipamento" required />
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-input-label for="local" value="Local da Ocorrência" />
                                <x-text-input id="local" class="block mt-1 w-full" type="text" name="local" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="erro_relatado" value="Erro Relatado" />
                                <textarea id="erro_relatado" name="erro_relatado" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="observacoes" value="Observações" />
                                <textarea id="observacoes" name="observacoes" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                             <a href="{{ route('tasklists.show', $tasklist) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Salvar O.S.') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>