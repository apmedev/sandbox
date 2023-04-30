
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <input wire:model="name" type="text" placeholder="Name">
                    <select wire:model="status">
                        <option value="">-- Select Status --</option>
                        <option value="created">Created</option>
                        <option value="assigned">Assigned</option>
                        <option value="processing">Processing</option>
                        <option value="done">Done</option>
                        <option value="cantfix">Can't Fix</option>
                    </select>
                    <button type="submit">Apply Filters</button>
                    <table class="w-full text-sm text-left text-gray-500 text-black-400">
                    
                        <thead class="text-xs text-gray-700 uppercase text-black-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ticket name
                            </th>
                                <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($tickets as $ticket)
                            <tr class="bg-white bg-gray-800 border-b border-gray-700">
                               <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                                    {{ $ticket->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                                    {{ $ticket->status }}
                                </td>
                                <td class="px-6 py-4">
                                @can('edit ticket')
                                    <x-link href="{{ route('tickets.edit', $ticket->id) }}" class="inline-flex items-center px-4 py-2 m-4 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                    Edit
                                    </x-link>
                                @endcan
                                @can('delete ticket')
                                    <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" class="inline-block">
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
                            <tr class="bg-white bg-gray-800 border-b border-gray-700">
                                <td colspan="2"
                                    class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                                    {{ __('No tickets found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>