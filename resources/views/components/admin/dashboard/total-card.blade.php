<div class="px-1 bg-white dark:bg-gray-800 dark:text-gray-400 shadow-sm rounded-lg text-center">
    <h2 class="text-xl border-b border-gray-300 dark:border-gray-600 pt-6 pb-4">{{ $title }}</h2>

    <p class="pt-6 pb-4 text-4xl font-bold dark:text-gray-100">
        {{ str()->padLeft($value, 2, '0') }}
    </p>
</div>
