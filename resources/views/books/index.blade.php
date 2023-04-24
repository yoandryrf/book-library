@php
    $userId = $user->id;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @switch(session('status'))
                @case('book-created')
                    <x-action-message>{{ __('The book was created successfully') }}</x-action-message>
                @break
                @case('book-updated')
                    <x-action-message>{{ __('The book was updated successfully') }}</x-action-message>
                @break
                @case('book-deleted')
                    <x-action-message>{{ __('The book was deleted successfully') }}</x-action-message>
                @break
                @case('book-restored')
                    <x-action-message>{{ __('The book was restored successfully') }}</x-action-message>
                @break
                @case('book-reserved')
                    <x-action-message>{{ __('The book was reserved successfully') }}</x-action-message>
                @break
                @case('book-returned')
                    <x-action-message>{{ __('The book was returned successfully') }}</x-action-message>
                @break
                
        @endswitch
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                @if($crud)
                    <div class="flex flex-row-reverse	">
                        <a href="{{ route('books.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create book</a>
                    </div>
                @endif

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
                                            <th scope="col" class="px-6 py-3 flex justify-end">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($books as $book)
                                            <tr class="border-b border-gray-100">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $book->title }}
                                                </th>
                                                <td class="px-6 py-4 description">
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
                                                <td class="px-6 py-4 flex items-center justify-end">
                                                    @if($crud)
                                                            @if (empty($book->deleted_at))
                                                                <a href="{{ route('books.edit', ['book' => $book->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</a>
                                                                <form method="POST" action="{{ route('books.destroy', ['book' => $book->id]) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <x-danger-button class="ml-3">
                                                                        {{ __('Delete') }}
                                                                    </x-danger-button>
                                                                </form>
                                                            @else
                                                                <form method="POST" action="{{ route('books.restore', ['book' => $book->id]) }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <x-primary-button class="ml-3">
                                                                        {{ __('Restore') }}
                                                                    </x-primary-button>
                                                                </form>
                                                                
                                                            @endif
                                                    @else
                                                        @php
                                                            $reserved =  !empty($book->reserved_by);
                                                            $reservedBySame = $reserved && $book->reserved_by == $userId;
                                                        @endphp
                                                        <form method="POST" action="{{ route('reservations.reserve', ['book' => $book->id]) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <x-primary-button disabled="{{ $reserved }}">
                                                                {{ __('Reserve') }}
                                                            </x-primary-button>
                                                        </form>
                                                    @endif
                                                </td>
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
