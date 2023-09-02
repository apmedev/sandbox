<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class TableFilterUsers extends Component
{
    public $name;
    public $email;

    public function render()
    {
        $users = User::query()
        ->when($this->name, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($this->email, function ($query, $email) {
            $query->where('email', $email);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('livewire.table-filter', [
            'users' => $users,
        ]);
    }
}
