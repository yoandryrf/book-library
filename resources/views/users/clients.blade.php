@php
    $userId = $user->id;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="max-w">
                    @if ($clients->isNotEmpty())
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Last Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Identification
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Current reservations
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr class="border-b border-gray-100">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $client->name }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $client->last_name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $client->identification }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $client->reservations()->count() }}
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>

                                {{ $clients->links('custom-pagination') }}
                    
                    @else
                        <div class="p-4 mb-4 text-center text-sm text-black rounded-lg bg-blue-50 dark:bg-blue-100" role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="font-medium">No items found.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
