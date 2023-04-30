<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tickets list') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            @can('create ticket')
                 <x-link href="{{ route('tickets.create') }}" class="m-4">Add new ticket</x-link>
            @endcan
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ticket name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($tickets as $ticket)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                               <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $ticket->name }}
                                </td>
                                <td class="px-6 py-4">
                                @can('edit ticket')
                                    <x-link href="{{ route('tickets.edit', $ticket) }}">Edit</x-link>
                                @endcan
                                @can('delete ticket')
                                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button
                                            type="submit"
                                            onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                    </form>
                                @endcan
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('No tickets found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>