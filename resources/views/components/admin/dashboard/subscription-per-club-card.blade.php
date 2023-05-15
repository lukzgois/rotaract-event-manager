<div class="py-6 px-1 bg-white dark:bg-gray-800 dark:text-gray-400 shadow-sm rounded-lg text-center">
    <h2 class="text-xl mb-2 border-b border-gray-300 dark:border-gray-600 pb-4">{{ $club }}</h2>

    <div class="pt-6 pb-4 text-4xl dark:text-white font-bold">{{ str()->padLeft($total, 2, '0') }}</div>

    <div class="grid grid-cols-2 border-t py-4 border-gray-300 dark:border-gray-600">
        <div class="border-r border-gray-300 dark:border-gray-600">
            <p class="text-sm">Pendentes</p>
            <p class="text-3xl">{{ str()->padLeft($pending, 2, '0') }}</p>
        </div>

        <div>
            <p class="text-sm">Confirmadas</p>
            <p class="text-3xl">{{ str()->padLeft($confirmed, 2, '0') }}</p>
        </div>
    </div>
</div>
