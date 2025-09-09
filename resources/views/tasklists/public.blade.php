<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista Compartilhada: {{ $taskList->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto mt-10 p-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">
            {{ $taskList->name }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Lista compartilhada por {{ $taskList->user->name }}.
        </p>

        <div class="space-y-4">
            @forelse ($tasks as $task)
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Equipamento: {{ $task->equipamento ?? 'N/A' }}
                    </p>
                </div>
            @empty
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                    <p class="text-gray-500 dark:text-gray-400">Esta lista não tem nenhuma tarefa no momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>