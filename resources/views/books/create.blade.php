<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Book Information') }}
                            </h2>
                        </header>
                    
                        <form method="post" action="{{ route('books.store') }}" class="mt-6 space-y-6">
                            @csrf
                    
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                    
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-textarea-input id="description" name="description" type="text" rows=6 class="mt-1 block w-full" required autofocus autocomplete="description" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                <x-cancel-button href="{{ route('books.index') }}">{{ __('Cancel') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
