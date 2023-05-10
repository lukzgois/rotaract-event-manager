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
                        Faltam <span class="text-2xl font-semibold">{{ $remaining_days }}</span> dias para o evento, e as inscrições se encontram no <span class="text-2xl font-bold">{{ config('payment.ticket_batch') }}º lote</span>, no valor de <span class="text-2xl font-bold">R$ {{ config('payment.ticket_price') }}</span>.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($subscription->isPending())
                        <h2 class="text-xl text-center sm:text-left text-red-600 font-bold mb-4">
                            Sua inscrição ainda não está confirmada.
                        </h2>

                        <p>
                            Mas não se preocupe, é muito fácil realizar o pagamento! <br>
                            Você pode optar por qualquer uma das formas abaixo:
                        </p>
                    @endif

                    @if($subscription->isPaid())
                        <h2 class="text-xl font-bold text-green-600 mb-4">
                            Sua inscrição está confirmada!
                        </h2>

                        <p>
                            Prepare suas provisões, seu rum e sua espada, pois o mar nos espera marujo!
                        </p>
                    @endif
                </div>
            </div>

            @if($subscription->isPending())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center sm:text-left font-bold mb-4">Pagamento via PIX</h2>

                    <div class="flex flex-wrap md:flex-nowrap items-center mb-4">
                        <div class="md:mr-4 md:basis-1/2">
                            <img src="{{ Vite::asset($qrcode) }}" />
                        </div>

                        <div>
                            <p class="my-2">
                                Chave PIX:
                                <strong>42999798002</strong>
                                <a href="#" class="text-blue-500 text-sm underline" onclick="copyPixKey(); return false">Copiar</a>
                            </p>

                            <p class="my-2">
                                Valor:
                                <strong>R$ {{ config('payment.ticket_price')}}</strong>
                                <a href="#" class="text-blue-500 text-sm underline" onclick="copyPixValue(); return false">Copiar</a>
                            </p>
                            <p class="my-2">Nome: <strong>Fernanda Gurgel Matakas</strong><p>
                            <p class="my-2 break-all">
                                Pix copia e cola: <br>
                                <strong>
                                    {{ config('payment.pix_code') }}
                                </strong>
                            <p>
                            <a href="#" class="text-blue-500 text-sm underline" onclick="copyPixCode(); return false">Copiar</a>
                        </div>
                    </div>

                    <div class="text-xl text-center">
                        <hr class="my-4">
                        Após o pagamento, enviar o comprovante para <a href="mailto:codircdossetemares@gmail.com" target="_blank" class="text-blue-500 underline">codircdossetemares@gmail.com</a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center sm:text-left font-bold mb-4">Pagamento via Depósito Bancário (igual aos antigos astecas)</h2>

                    <p class="my-2">Nome: <strong>Fernanda Gurgel Matakas</strong><p>
                    <p class="my-2">Valor: <strong>R$ {{ config('payment.ticket_price') }}</strong></p>
                    <p class="my-2">Agência: <strong>0645-9</strong></p>
                    <p class="my-2">Conta: <strong>51.227-3</strong></p>
                    <p class="my-2"><strong>Banco do Brasil</strong></p>

                    <div class="text-xl text-center">
                        <hr class="my-4">
                        Após o pagamento, enviar o comprovante para <a href="mailto:codircdossetemares@gmail.com" target="_blank" class="text-blue-500 underline">codircdossetemares@gmail.com</a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center sm:text-left font-bold mb-4">Pagamento parcelado via Cartão de Crédito</h2>

                    <p class="my-4">
                        Caso queira, você pode realizar o pagamento parcelado usando um cartão de crédito.<br>
                        Utilizamos o <span class="font-semibold">Mercado Pago</span> para oferecer essa opção, o que acarreta em algumas taxas adicionais, que serão acrescentadas à sua inscrição.<br>
                        Para realizar o pagamento com cartão de crédito, clique no botão abaixo:
                    </p>

                    <p class="text-center">
<script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
data-preference-id="168858925-a33f91ac-3a1b-4a1c-b37a-4ff81e543c69" data-source="button">
</script>
                    </p>

                    <div class="text-xl text-center">
                        <hr class="my-4">
                        Após o pagamento, enviar o comprovante para <a href="mailto:codircdossetemares@gmail.com" target="_blank" class="text-blue-500 underline">codircdossetemares@gmail.com</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
function copyPixCode() {
    navigator.clipboard.writeText('{{ config("payment.pix_code") }}')
}

function copyPixKey() {
    navigator.clipboard.writeText('42999798002')
}

function copyPixValue() {
    navigator.clipboard.writeText('{{ config("payment.ticket_price") }}')
}
</script>
