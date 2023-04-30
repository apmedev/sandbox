<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = auth()->user()->getRoleNames()[0]; // get the user's role

        if ($role === 'Administrator') {
            // administrator can see all tickets
            $tickets = DB::table('tickets')
                ->select('*')
                ->whereNull('agent_id')
                ->orderBy('created_at', 'desc')
                ->orderByRaw("
                    CASE status
                        WHEN 'created' THEN 1
                        WHEN 'assigned' THEN 2
                        WHEN 'processing' THEN 3
                        WHEN 'done' THEN 4
                        WHEN 'cantfix' THEN 5
                    END
                ")
                ->get();
        } elseif ($role === 'Customer') {
            // customer can only see their own tickets
            $tickets = DB::table('tickets')
                ->select('*')
                ->where('creator_id', '=', auth()->id())
                ->orderBy('created_at', 'desc')
                ->orderByRaw("
                    CASE status
                        WHEN 'created' THEN 1
                        WHEN 'assigned' THEN 2
                        WHEN 'processing' THEN 3
                        WHEN 'done' THEN 4
                        WHEN 'cantfix' THEN 5
                    END
                ")
                ->get();

        } elseif ($role === 'Agent') {
            // admin can see tickets assigned to them or unassigned

            $tickets = DB::table('tickets')
                ->select('*')
                ->where('agent_id', '=', auth()->id())
                ->orderBy('created_at', 'desc')
                ->orderByRaw("
                    CASE status
                        WHEN 'created' THEN 1
                        WHEN 'assigned' THEN 2
                        WHEN 'processing' THEN 3
                        WHEN 'done' THEN 4
                        WHEN 'cantfix' THEN 5
                    END
                    ")
                    ->get();
        }
 
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create ticket');

        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $this->authorize('create ticket');
        //dd($request->validated());
        Ticket::create($request->validated());

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('edit ticket');

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorize('edit ticket');

        $ticket->update($request->validated());
 
        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete ticket');

        $ticket->delete();
 
        return redirect()->route('tickets.index');
    }
}
