<x-pages-layout>
    <div class="p-4 text-white relative flex flex-col justify-center items-center h-screen">
        <a href="/" class="rounded-full bg-white/30 w-32 h-32 flex items-center justify-center">
            <img src="{{ Vite::asset('resources/images/logo-120x175.png') }}" width="75" />
        </a>

        <div class="text-white mt-6 bg-sky-800/50 p-4 rounded-lg">
            <table class="table-auto text-lg">
                <thead>
                    <tr class="h-12 text-xl font-bold border-b">
                        <th class="text-left">Nome</th>
                        <th class="text-left">Clube</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td class="pr-16">{{ $participant->name }}</td>
                            <td class="pr-4">{{ $participant->club_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-pages-layout>
