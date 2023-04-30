<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class TableFilter extends Component
{
    public $name;
    public $status;

    public function render()
    {
        $tickets = Ticket::query()
        ->when($this->name, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($this->status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('livewire.table-filter', [
            'tickets' => $tickets,
        ]);
    }
}
