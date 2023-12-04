<?php

namespace App\Http\Controllers\Ticket;

use App\Models\Ticket;
use App\Models\File;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        if (!isset($_GET['project_id'])) {
            return redirect()->back()->with(['message' => "No Project ID Provided, try again!"]);
        }

        $project_id = $_GET['project_id'];

        $project = Project::findOrFail($project_id);

        $tasks = $project->tasks;

        return view("pm-dashboard.ticket.add-ticket", compact("project","tasks"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

         if (!isset($request->project_id)) {
            return redirect()->back()->with(['message' => "Project ID required", "result" => "danger"]);
        }

        $project = Project::findOrFail($request->project_id);

        $validated = $request->validate(
            [
                "ticket_name" => "required",
                'ticket_description' => "required",
                'ticket_deadline' => "required",
                'priority' => "required",
                "project_id" => "required",
                "reference_task_id"=>"nullable"

            ],
            [
                "ticket_name.required" => "ticket Name is required",
                "ticket_name.unique" => strtoupper($request->ticket_name) . " is already added",
                "ticket_description.required" => "ticket description is required",
                "budget.numeric" => "ticket budget must be a number",
                "priority.required" => "You must select a Priority",
            ]

        );


        $validated['status']="pending";
        $ticket = Ticket::create($validated);


        if($request->hasFile("files")){

            $files= $request->file("files");

            foreach($files as $file){

                $path= $file->storePublicly("public/ticket/images");

                $_image= File::create([
                        "file_name"=>$file->getClientOriginalName(),
                        "file_path"=> $path,
                        "file_type"=>$file->getClientOriginalExtension(),
                        "parent_id"=> $ticket->id,
                        "model"=> Ticket::class   
                ]);

                $ticket->has_attachments=true;
                $ticket->save();

            }
        }



        $team= Team::findOrFail($project->team_id);

        ///send notification
        $title="A new Ticket ( {$ticket->team_name} ) has Been Added to Project ( {$project->project_name} )";
        $link= route("project.client", ["project",$project->id]);
        $content= $validated['ticket_description'];

        sendNotifcation($team->team_lead_id, $title, $content, $link);


        return redirect()->route("project.client", ['project' => $request->project_id])->with(['message' => 'Ticket Added Successfully!', 'result' => 'success']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket= Ticket::findOrFail($id);
       return view("pm-dashboard.ticket.details-ticket", compact("ticket"));
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
       
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $ticket=  Ticket::findOrFail($id);

        $ticket->delete();

        return redirect()->back()->with(['message' => 'Ticket Deleted!', 'result' => 'success']);
        
    }




    public function submitTicket(Request $request){
      
        if (!isset($request->ticket_id) | !isset($request->status)) {
            return redirect()->back()->with(['message' => "Ticket ID required", "result" => "danger"]);
        }

        $ticket= Ticket::findOrFail($request->ticket_id);

        $ticket->status= $request->status;
         
        $ticket->save();

        return redirect()->back()->with(['message'=> 'Ticket Set to '.strtoupper($request->status), 'result' => 'success']);
    }
}
