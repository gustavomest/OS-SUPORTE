<x-app-layout>
    {{-- Alpine.js: Inicializa as variáveis para o modal --}}
    <div x-data="{ showModal: false, selectedOrder: null }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard - O.S. Pendentes') }}
            </h2>
        </x-slot>

        {{-- Carrega todos os dados das O.S. em uma variável JavaScript --}}
        <script>
            const ordersData = @json($pendingOrders->keyBy('id'));
        </script>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- Grid responsivo para os cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($pendingOrders as $order)
                        {{-- O Card Clicável --}}
                        <div @click="showModal = true; selectedOrder = ordersData[{{ $order->id }}]"
                             class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 cursor-pointer transform hover:scale-105 transition duration-300">

                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $order->title }}</h3>
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-yellow-200 text-yellow-800">
                                    Pendente
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>O.S:</strong> {{ $order->ordem_servico }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Equipamento:</strong> {{ $order->equipamento }}</p>
                            {{-- Adicionando o nome do usuário, importante para a visão do admin --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Usuário:</strong> {{ $order->taskList->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-4">{{ \Carbon\Carbon::parse($order->data_hora_abertura)->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                            <p class="text-gray-900 dark:text-gray-100">Nenhuma Ordem de Serviço pendente encontrada.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- O Modal (inicialmente escondido) --}}
        <div x-show="showModal" @keydown.escape.window="showModal = false" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 px-4" style="display: none;">
            <div @click.outside="showModal = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <template x-if="selectedOrder">
                    <div>
                        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Detalhes da O.S: <span x-text="selectedOrder.ordem_servico"></span></h3>
                            <button @click="showModal = false" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300">&times;</button>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700 dark:text-gray-300">
                            <div><strong class="text-gray-500 dark:text-gray-400">Título:</strong> <span x-text="selectedOrder.title || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Status:</strong> <span x-text="selectedOrder.is_complete ? 'Concluído' : 'Pendente'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Data Abertura:</strong> <span x-text="selectedOrder.data_hora_abertura ? new Date(selectedOrder.data_hora_abertura).toLocaleString('pt-BR') : 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Resp. Abertura:</strong> <span x-text="selectedOrder.responsavel_abertura || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Tipo:</strong> <span x-text="selectedOrder.tipo || 'N/A'"></span></div>
                            <div><strong class="text-gray-500 dark:text-gray-400">Quadro de Trabalho:</strong> <span x-text="selectedOrder.quadro_trabalho || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Equipamento:</strong> <span x-text="selectedOrder.equipamento || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Local:</strong> <span x-text="selectedOrder.local || 'N/A'"></span></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Erro Relatado:</strong> <p class="mt-1" x-text="selectedOrder.erro_relatado || 'Nenhum erro relatado.'"></p></div>
                            <div class="md:col-span-2"><strong class="text-gray-500 dark:text-gray-400">Observações:</strong> <p class="mt-1" x-text="selectedOrder.observacoes || 'Nenhuma observação.'"></p></div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <a :href="`/tasks/${selectedOrder.id}/edit`" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Editar
                                </a>
                                <form method="POST" :action="`/tasks/${selectedOrder.id}`" onsubmit="return confirm('Tem certeza que deseja excluir esta O.S.?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Excluir
                                    </button>
                                </form>
                            </div>
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