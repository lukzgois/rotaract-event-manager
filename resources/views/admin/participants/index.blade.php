<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center gap-x-3">
                <h3 class="text-2xl font-medium text-gray-800 dark:text-white">{{ __("Participants") }}</h3>
                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $participants->total() }} {{ __("Participants")}}</span>
            </div>

            <div class="mb-4 inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
                    {{ __("View all")}}
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Confirmadas
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Pendentes
                </button>
            </div>

            <div class="mb-4 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-4 text-left rtl:text-right text-gray-500 dark:text-gray-400">{{ __("Name") }}</th>
                                    <th class="p-4 text-left rtl:text-right text-gray-500 dark:text-gray-400">{{ __("Nickname") }}</th>
                                    <th class="p-4 text-left rtl:text-right text-gray-500 dark:text-gray-400">{{ __("Club") }}</th>
                                    <th class="p-4 text-left rtl:text-right text-gray-500 dark:text-gray-400">{{ __("Subscription") }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            @foreach($participants as $participant)
                                <tr class="text-gray-700 dark:text-gray-300">
                                    <td class="p-4 whitespace-nowrap">{{ $participant->name }}</td>
                                    <td class="p-4 whitespace-nowrap">{{ $participant->nickname }}</td>
                                    <td class="p-4 whitespace-nowrap">{{ $participant->club->name }}</td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if($participant->subscription->isPaid())
                                            <div class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-500 gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                                                {{ __("Confirmed") }}
                                            </div>
                                        @else
                                            <div class="inline px-3 py-1 text-sm font-normal text-gray-500 bg-gray-100 rounded-full dark:text-gray-400 gap-x-2 dark:bg-gray-800">
                                                {{ __("Pending") }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <a href="{{ route('participants.confirmSubscription', ['participant' => $participant->id]) }}" class="text-blue-500 hover:underline">{{ __("View") }}</a> <br>
                                        <a href="#" class="text-blue-500 hover:underline">{{ __("Edit") }}</a><br>
                                        <a href="#" class="text-blue-500 hover:underline">{{ __("Confirm subscription") }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                {{ $participants->links() }}
            </div>
        </div>
    </div>
</x-app-layout>