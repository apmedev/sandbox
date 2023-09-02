<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex p-8">
        <div class="w-1/3">
            <input wire:model="email" type="text" placeholder="Email" class="block mt-1">
        </div>
        <div class="w-1/3">
            <select wire:model="status">
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="agent">Agent</option>
                <option value="customer">Customer</option>
            </select>
        </div>
        <div class="w-1/3">
            <button type="submit" class="inline-flex items-center px-4 py-2 m-4 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">Apply Filters</button>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 text-black-400">
        <thead class="text-xs text-gray-700 uppercase text-black-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr class="bg-white bg-gray-800 border-b border-gray-700">
                <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                    {{ $user->id }}
                </td>
                <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                    {{ $user->name }}
                </td>
                <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                    Role
                </td>
                <td class="px-6 py-4">
                    @can('delete user')
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr class="bg-white bg-gray-800 border-b border-gray-700">
                <td colspan="2" class="px-6 py-4 font-medium text-black text-gray-900 whitespace-nowrap">
                    {{ __('No users found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
