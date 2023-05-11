<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl">{{ __("Welcome user!") }}, <span class="font-semibold">{{ Auth::user()->name }}!</span></h3>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-x-4">
                <x-admin.dashboard.total-card title="Total de Inscrições" :value="$participants" />
                <x-admin.dashboard.total-card title="Inscrições Confirmadas" :value="$confirmed" />
                <x-admin.dashboard.total-card title="Inscrições Pendentes" :value="$pending" />
            </div>
        </div>
    </div>
</x-app-layout>
