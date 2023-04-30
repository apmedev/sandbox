<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets list') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-link href="{{ route('tickets.create') }}" class="m-4">Add new ticket</x-link>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ticket name
                            </th>
                            <th scope="col" class="px-6 py-3">
 
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
                                    <x-link href="{{ route('tickets.edit', $ticket) }}">Edit</x-link>
                                    <form method="POST" action="{{ route('tasks.destroy', $ticket) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button
                                            type="submit"
                                            onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                    </form>
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