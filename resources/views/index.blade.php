<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CODIRC dos Sete Mares ⚓</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600|orbitron:400&display=swap" rel="stylesheet" />

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased w-full">
        <div class="bg-[url('../images/homepage-background.jpg')] min-h-screen bg-cover bg-center fixed w-full"></div>
        <div class="bg-gradient-to-b from-sky-900 to-sky-100 w-full min-h-screen fixed opacity-30"></div>

        <div class="p-4 text-white relative flex flex-col justify-center items-center h-screen">
            <div class="rounded-full bg-white/30 w-48 h-48 flex items-center justify-center">
                <img src="{{ Vite::asset('resources/images/logo-120x175.png') }}" />
            </div>

            <h1 class="text-4xl text-center mt-4">Sejam bem vindos aos Sete Mares, Marujos!</h1>

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
    </body>
</html>
