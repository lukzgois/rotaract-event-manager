<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl">{{ __("Welcome user!") }}, <span class="font-semibold">{{ Auth::user()->name }}!</span></h3>
                    <p class="my-4">
                        É uma honra contar com sua presença para a <strong>CODIRC dos sete mares</strong>, estamos ansiosos para receber você e seus companheiros marítimos.
                    </p>

                    <p class="my-4">
                        Faltam <span class="text-2xl font-semibold">{{ $remaining_days }}</span> dias para o evento, e as inscrições se encontram no <span class="text-2xl font-bold">{{ ENV('TICKET_BATCH') }}º lote</span>, no valor de <span class="text-2xl font-bold">R$ {{ ENV('TICKET_BATCH_PRICE') }}</span>.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">
                        Sua inscrição ainda não está confirmada.
                    </h2>

                    <p>
                        Mas não se preocupe, é muito fácil realizar o pagamento! <br>
                        Você pode optar por qualquer uma das formas abaixo:
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Pagamento via PIX</h2>

                    <p>
                        Chave PIX: <strong>fematakas@gmail.com</strong><br>
                        Nome: Fernanda Gurgel Matakas
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Pagamento parcelado via Cartão de Crédito</h2>

                    <p class="my-4">
                        Caso queira, você pode realizar o pagamento parcelado usando um cartão de crédito.<br>
                        Utilizamos o <span class="font-semibold">Mercado Pago</span> para oferecer essa opção, e por isso possui algumas taxas adicionais, que serão acrescentadas à sua inscrição.<br>
                        Para realizar o pagamento com cartão de crédito, clique no botão abaixo:
                    </p>

                    <p class="text-center">
<script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
data-preference-id="168858925-a33f91ac-3a1b-4a1c-b37a-4ff81e543c69" data-source="button">
</script>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
