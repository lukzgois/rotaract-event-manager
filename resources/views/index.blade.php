<x-pages-layout>
    <div class="p-4 text-white relative flex flex-col justify-center items-center h-screen">
        <div class="rounded-full bg-white/30 w-48 h-48 flex items-center justify-center">
            <img src="{{ Vite::asset('resources/images/logo-120x175.png') }}" />
        </div>

        <h1 class="text-4xl text-center mt-4">Sejam bem-vindos aos Sete Mares, Marujos!</h1>

        <p class="text-center mt-4 mb-6 md:max-w-lg">
            A tripulação de Guarapuava orgulhosamente convida vocês a embarcarem nessa aventura pelos mistérios dos mares. Icem as velas e subam a âncora, pois está na hora de partir!
        </p>

        <div class="flex flex-col space-y-4 sm:space-y-0 sm:space-x-4 sm:flex-row">
            <a href="/register" class="text-center block no-underline border-white rounded border-2 w-48 p-2 text-xl hover:bg-sky-700">Inscreva-se</a>
            <a href="/login" class="text-center block no-underline border-white rounded border-2 w-48 p-2 text-xl hover:bg-sky-700">Entre</a>
        </div>

        <div class="mt-8 text-center">
            <a href="/inscritos" class="text-blue-300 underline">Confira aqui quem já está pronto para essa aventura!</a>
        <div>
    </div>
</x-pages-layout>
