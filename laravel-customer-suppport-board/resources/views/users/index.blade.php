<x-app-layout>
    <x-slot name="header">
    <div class="flex">
        <div class="w-1/2">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Users list') }}
            </h2>
        </div>
        /**
            <div class="w-1/2">
            @can('invite user')
                <x-link href="{{ route('users.invite') }}" type="button"  class="inline-flex items-center px-4 py-2 m-4 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                    Invite user
                </x-link>
            @endcan
            </div>
        */
    </div>
    </x-slot>
 
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('table-filter-users', ['users' => $users])
            </div>
        </div>
    </div>
</x-app-layout>