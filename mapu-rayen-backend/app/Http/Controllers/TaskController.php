<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request){

        $projects_list = array();

        $filter = $request->filter;

        if ($filter == '') {
            $tasks = Task::select('tasks.id', 'tasks.name', 'tasks.project_id', 'tasks.type', 'tasks.isnull', 'tasks.start', 'tasks.finish', 'tasks.cost', 'tasks.percentComplete', 'tasks.percentWorkComplete')
                ->orderBy('tasks.id', 'desc')->paginate(5);

            foreach($tasks as &$task){
                $project = Project::where('projects.id',$task->project_id)->first();
                $project_name = $project->project;
                array_push($projects_list, $project_name);
            }

        } else {
            $tasks = Task::select('tasks.id', 'tasks.name', 'tasks.project_id', 'tasks.type', 'tasks.isnull', 'tasks.start', 'tasks.finish', 'tasks.cost', 'tasks.percentComplete', 'tasks.percentWorkComplete')
                ->where('tasks.name', 'like', "%$filter%")
                ->orWhere('tasks.id', 'like', "%$filter%")
                ->orderBy('tasks.id', 'desc')->paginate(5);

            foreach($tasks as &$task){
                $project = Project::where('projects.id',$task->project_id)->first();
                $project_name = $project->name;
                array_push($projects_list, $project_name);
            }
        }

        return [
            'pagination' => [
                'total' => $tasks->total(),
                'current_page' => $tasks->currentPage(),
                'per_page' => $tasks->perPage(),
                'last_page' => $tasks->lastPage(),
                'from' => $tasks->firstItem(),
                'to' => $tasks->lastItem(),
            ],
            'tasks' => $tasks,
            'projects_list' => $projects_list
        ];
    }


    public function store(Request $request)
    {
        $task = new Task();
        $task->name = $request->name;
        $task->project_id = 1;
        $task->type = $request->type;
        $task->isnull = $request->isnull;
        $task->start = $request->start;
        $task->finish = $request->finish;
        $task->cost = $request->cost;
        $task->percentComplete = $request->percentComplete;
        $task->percentWorkComplete = $request->percentWorkComplete;


        $task->save();
        return ['status' => 'OK'];
    }

    public function update(Request $request)
    {

        $task = Task::findOrFail($request->id);
        $task->name = $request->name;
        $task->project_id = 1;
        $task->type = $request->type;
        $task->isnull = $request->isnull;
        $task->start = $request->start;
        $task->finish = $request->finish;
        $task->cost = $request->cost;
        $task->percentComplete = $request->percentComplete;
        $task->percentWorkComplete = $request->percentWorkComplete;


        $task->save();
        return ['status' => 'OK'];
    }

    public function delete(Request $request, $id)
    {

        $task = Task::findOrFail($id)->delete();
        return ['status' => 'OK'];
    }



    public function getTasks()
    {

        $tasks = Task::select('tasks.id', 'tasks.name')
            ->orderBy('tasks.id', 'desc')->get();
        return [
            'tasks' => $tasks
        ];

    }
}
