@php
    $userId = $user->id;
    $now = \Carbon\Carbon::now();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservations list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @switch(session('status'))
                @case('book-reserved')
                    <x-action-message>{{ __('The book was reserved successfully') }}</x-action-message>
                @break
                @case('book-returned')
                    <x-action-message>{{ __('The book was returned successfully') }}</x-action-message>
                @break
                
        @endswitch
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="max-w">
                    @if ($books->isNotEmpty())
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Description
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Return status
                                            </th>
                                            @if (!$crud)
                                               <th scope="col" class="px-6 py-3 flex justify-end">
                                                    Actions
                                                </th>
                                            @else
                                                <th scope="col" class="px-6 py-3">
                                                    Maximum return date
                                                </th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($books as $book)
                                            <tr class="border-b border-gray-100">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $book->title }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $book->description }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if ($book->reserved_by)
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-red-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            <span class="w-5 h-5 text-red-500 font-bold">
                                                                @if ($crud) {{ $book->client?->name . ' '. $book->client?->last_name }}  @else  Unavailable @endif
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-green-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                            <span class="w-5 h-5 text-green-500 font-bold">Available</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                @php
                                                    $limit = \Carbon\Carbon::parse($book->reserved_at)->endOfDay()->addHours(48);
                                                @endphp
                                                <td class="px-6 py-4">
                                                    @if ($now->isBefore($limit))
                                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">In Time</span>
                                                    @else
                                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Late</span>
                                                    @endif
                                                </td>
                                                @if (!$crud)
                                                    <td class="px-6 py-4 flex items-center justify-end">
                                                        @php
                                                            $reserved = !empty($book->reserved_by);
                                                            $reservedBySame = $reserved && $book->reserved_by == $userId;
                                                        @endphp
                                                        <form method="POST" action="{{ route('reservations.return', ['book' => $book->id]) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <x-primary-button disabled="{{ !$reservedBySame }}" class="ml-2">
                                                                {{ __('Return') }}
                                                            </x-primary-button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td class="px-6 py-4">
                                                        {{ $limit->copy()->isoFormat('MMMM D YYYY hh:mm') }}
                                                    </td>
                                                    
                                                @endif
                                                
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>

                                {{ $books->links('custom-pagination') }}
                    
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
