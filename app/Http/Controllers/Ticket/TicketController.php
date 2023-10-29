<?php

namespace App\Http\Controllers\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
          /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view("pm-dashboard.ticket.all-tickets");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pm-dashboard.project.add-project");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //


        
    }




    public function submitTicket(Request $request){
      
        if (!isset($request->ticket_id) | !isset($request->status)) {
            return redirect()->back()->with(['message' => "Ticket ID required", "result" => "danger"]);
        }

        $task= Ticket::findOrFail($request->ticket_id);

        $task->status= $request->status;
         
        $task->save();

        return redirect()->back()->with(['message'=> 'Ticket Set to '.strtoupper($request->status), 'result' => 'success']);
    }
}
