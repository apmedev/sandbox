<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add New Ticket') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="relative px-4 py-4 overflow-x-auto shadow-md sm:rounded-lg">
                    <x-validation-errors class="mb-4" />
 
                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf
 
                        <div>
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-label for="description" value="{{ __('Description') }}" />
                            <x-input id="description" class="block w-full mt-1" type="text" name="description" :value="old('description')" required autofocus autocomplete="description" />
                        </div>
 
                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Save Ticket') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>