<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function superDashboard()
    {

        $total_projects = Project::count();
        $pending_tickets = Ticket::where("status", "!=", "completed")->count();
        $pending_tasks = Task::where("status", "!=", "completed")->count();
        $best_team = Project::select("team_id")->where("project_status", "complete")->groupBy("team_id")->orderByRaw("Count(*) DESC")->first();



        //Tasks in every priority
        $task_in_every_priortiy = Task::select(DB::raw("count(*) as number"), "priority")->where("status", "pending")->groupBy("priority")->get();
        $task_in_every_priortiy_arr = [];
        foreach ($task_in_every_priortiy as $task) {
            $task_in_every_priortiy_arr[$task->priority] = $task->number;
        }


        //Tickets in every priority
        $ticket_in_every_priortiy = Ticket::select(DB::raw("count(*) as number"), "priority")->where("status", "pending")->groupBy("priority")->get();
        $ticket_in_every_priortiy_arr = [];
        foreach ($ticket_in_every_priortiy as $task) {
            $ticket_in_every_priortiy_arr[$task->priority] = $task->number;
        }


        //new Project
        $porject_success_months_new_prjects =  Project::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get()->toArray();

        $porject_success_months_new_prjects_arr = [];
        foreach ($porject_success_months_new_prjects as $succ_project) {
            $porject_success_months_new_prjects_arr[$succ_project['month']] = $succ_project['count'];
        }

        //Completed Project
        $porject_complete_months_completed_prjects =  Project::select(DB::raw('MONTH(updated_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('updated_at', Carbon::now()->year)
            ->where("project_status", "completed")
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->get()->toArray();

        $porject_success_months_completed_prjects_arr = [];
        foreach ($porject_complete_months_completed_prjects as $succ_project) {
            $porject_success_months_completed_prjects_arr[$succ_project['month']] = $succ_project['count'];
        }


        $best_team_projects = null;
        if ($best_team != null) {
            $best_team = Team::find($best_team->team_id);
            $best_team_projects = Project::Where("team_id", "=", $best_team->id)
                ->where("project_status", "complete")->count();
        }

        $total_income = Project::where("project_status", "complete")->sum("budget");
        $total_users = User::count();

        $latest_project= Project::where("project_status","pending")->orderBy("created_at","desc")->limit(10)->get();

        return view(
            "pm-dashboard.home",
            compact(
                "total_projects",
                "pending_tickets",
                "pending_tasks",
                "best_team",
                "total_income",
                "best_team_projects",
                "total_users",
                "porject_success_months_new_prjects_arr",
                "porject_success_months_completed_prjects_arr",
                "task_in_every_priortiy_arr",
                "ticket_in_every_priortiy_arr",
                "latest_project"
            )
        );
    }
}
