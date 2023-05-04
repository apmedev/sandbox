<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Ticket') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="relative px-4 py-4 overflow-x-auto shadow-md sm:rounded-lg">
                    <x-validation-errors class="mb-4" />
 
                    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                        @csrf
                        @method('PUT')
 
                        <div>
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="$ticket->name" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-label for="description" value="{{ __('Description') }}" />
                            <x-input id="description" class="block w-full mt-1" type="text" name="description" :value="$ticket->description" required autofocus autocomplete="description" />
                        </div>
                        @can('assign ticket')
                        <div>
                        <x-label for="agent_id" value="{{ __('Agent') }}" />
                        <select name="agent_id" id="agent_id">
                            @if($ticket->agent_id)
                                <option value="{{ $ticket->agent->id }}" disabled selected >{{ $ticket->agent->email }}</option>
                            @else
                                @foreach ($allAgents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->email }}</option>
                                @endforeach
                            @endif
                        </select>
                        </div>
                        @endcan
                        <div>
                            <x-label for="status-current" value="{{ __('Status') }}" />
                            <x-input id="status-current" class="block w-full mt-1" type="text" name="status-current" :value="$ticket->status" required autofocus disabled autocomplete="status" />
                        </div>

                        <div>
                            <x-label for="status">Update status:</x-label>
                            <select name="status" id="status" class="block w-full mt-1">
                            @foreach ($allStatuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                            </select>
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