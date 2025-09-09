<x-app-layout>
    {{-- Alpine.js: Inicializa as variáveis para o modal --}}
    <div x-data="{ showModal: false, selectedTask: null }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Lista: <span class="font-bold">{{ $tasklist->name }}</span>
            </h2>
        </x-slot>

        {{-- Carrega todos os dados em uma variável JS --}}
        <script>
            const tasksData = @json($tasks->keyBy('id'));
        </script>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- (Código da mensagem de sucesso e do botão de criar) --}}
                <div class="flex justify-end mb-4">
                     <a href="{{ route('tasklists.tasks.create', $tasklist) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Adicionar Nova O.S.') }}
                    </a>
                </div>

                {{-- Grid responsivo para os cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($tasks as $task)
                        <div @click="showModal = true; selectedTask = tasksData[{{ $task->id }}]" 
                             class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 cursor-pointer transform hover:scale-105 transition duration-300">
                            
                            {{-- (Conteúdo do card permanece o mesmo) --}}
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $task->title }}</h3>
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $task->is_complete ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ $task->is_complete ? 'Concluído' : 'Pendente' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>O.S:</strong> {{ $task->ordem_servico }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Equipamento:</strong> {{ $task->equipamento }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-4">{{ \Carbon\Carbon::parse($task->data_hora_abertura)->format('d/m/Y H:i') }}</p>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                            <p class="text-gray-900 dark:text-gray-100">Nenhuma Ordem de Serviço encontrada nesta lista.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- O Modal (com contraste melhorado e botões de ação) --}}
        <div x-show="showModal" @keydown.escape.window="showModal = false" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 px-4" style="display: none;">
            <div @click.outside="showModal = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <template x-if="selectedTask">
                    <div>
                        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Detalhes da O.S: <span x-text="selectedTask.ordem_servico"></span></h3>
                            <button @click="showModal = false" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300">&times;</button>
                        </div>
                        
                        {{-- Corpo do Modal com Melhoria de Contraste --}}
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700 dark:text-gray-300">
                            <div><strong class="text-gray-500 dark:text-gray-400">Título:</strong> <span x-text="selectedTask.title || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Status:</strong> <span x-text="selectedTask.is_complete ? 'Concluído' : 'Pendente'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Data Abertura:</strong> <span x-text="selectedTask.data_hora_abertura ? new Date(selectedTask.data_hora_abertura).toLocaleString('pt-BR') : 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Resp. Abertura:</strong> <span x-text="selectedTask.responsavel_abertura || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Tipo:</strong> <span x-text="selectedTask.tipo || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Quadro de Trabalho:</strong> <span x-text="selectedTask.quadro_trabalho || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Equipamento:</strong> <span x-text="selectedTask.equipamento || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Local:</strong> <span x-text="selectedTask.local || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Erro Relatado:</strong> <p class="mt-1" x-text="selectedTask.erro_relatado || 'Nenhum erro relatado.'"></p></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Observações:</strong> <p class="mt-1" x-text="selectedTask.observacoes || 'Nenhuma observação.'"></p></div>
                        </div>

                        {{-- Rodapé do Modal com os Botões de Ação --}}
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                            {{-- Botões de Editar e Excluir à esquerda --}}
                            <div class="flex items-center space-x-2">
                                {{-- Botão Editar --}}
                                <a :href="`/tasks/${selectedTask.id}/edit`" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Editar
                                </a>
                                {{-- Botão Excluir --}}
                                <form method="POST" :action="`/tasks/${selectedTask.id}`" onsubmit="return confirm('Tem certeza que deseja excluir esta O.S.?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                            {{-- Botão Fechar à direita --}}
                            <button @click="showModal = false" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Fechar
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>