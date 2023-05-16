<x-pages-layout>
    <div class="py-4 px-1 text-white relative flex flex-col justify-center items-center">
        <a href="/" class="rounded-full bg-white/30 w-32 h-32 flex items-center justify-center">
            <img src="{{ Vite::asset('resources/images/logo-120x175.png') }}" width="75" />
        </a>

        <p class="py-4 sm:px-4 text-center bg-sky-800/50 rounded-lg mt-4">
        <span class="text-4xl font-bold">{{ $participants->count() }}</span> <br>
            tripulantes já estão preparados para viajar pelos sete mares.
            O que você está esperando?
        </p>

        <div class="text-white mt-6 bg-sky-800/50 rounded-lg md:p-4">
            <table class="text-lg">
                <thead>
                    <tr class="h-12 text-xl font-bold border-b">
                        <th class="pl-1 text-left">Nome</th>
                        <th class="text-left">Clube</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr class="border-b border-dashed border-white/50">
                            <td class="pl-1 py-8 pr-16">{{ $participant->name }}</td>
                            <td class="">{{ $participant->club_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-pages-layout>
