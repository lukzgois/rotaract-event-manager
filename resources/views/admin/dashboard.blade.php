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

            <div class="p-4">
                <h2 class="mb-4 text-3xl dark:text-white text-center">Total de inscrições</h2>

                <div class="grid gap-y-4 sm:grid-cols-3 sm:gap-x-4 sm:gap-y-0">
                    <x-admin.dashboard.total-card title="Total de Inscrições" :value="$participants" />
                    <x-admin.dashboard.total-card title="Inscrições Confirmadas" :value="$confirmed" />
                    <x-admin.dashboard.total-card title="Inscrições Pendentes" :value="$pending" />
                </div>
            </div>

            <div class="mt-4 p-4">
                <h2 class="mb-4 text-3xl dark:text-white text-center">Inscrições por clube</h2>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach($subscriptions_per_club as $subscriptions)
                        <x-admin.dashboard.subscription-per-club-card
                            :club="$subscriptions->name"
                            :total="$subscriptions->total"
                            :confirmed="$subscriptions->paid"
                            :pending="$subscriptions->pending"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
