<x-app-layout>
        <div class="mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center gap-x-3">
                <h3 class="text-2xl font-medium text-gray-800 dark:text-white">
                    Confirmar Inscrição: {{ $participant->name }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="POST" action="{{ route('subscription.confirm', ['subscription' => $subscription->id]) }}">
                    @csrf

                    <div>
                        <x-input-label for="payment_form" value="Forma de Pagamento" />

                        <x-select-input id="payment_form"
                                        :options="$payment_forms"
                                        :selected="old('payment_form')"
                                        name="payment_form" required />

                        <x-input-error :messages="$errors->get('payment_form')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="ticket_batch" value="Lote de inscrições" />

                        <x-select-input id="ticket_batch"
                                        :options="$ticket_batches"
                                        :selected="old('ticket_batch')"
                                        name="ticket_batch" required />

                        <x-input-error :messages="$errors->get('ticket_batch')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="value" value="Valor" />
                        <x-text-input id="value" type="text" name="value" :value="old('value') ?? '180'" required autofocus />
                        <x-input-error :messages="$errors->get('value')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4 gap-4">
                        <x-secondary-link :href="route('participants.index')">
                            Cancelar
                        </x-secondary-link>

                        <x-primary-button>
                            Confirmar inscrição
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
</x-app-layout>
