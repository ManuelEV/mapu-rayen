<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{


    public function index(Request $request){

        $enterprises_list = array();

        $filter = $request->filter;

        if ($filter == '') {
            $projects = Project::select('projects.id', 'projects.project', 'projects.enterprise_id', 'projects.calendar_id')
                ->orderBy('projects.id', 'desc')->paginate(5);

            foreach($projects as &$project){

                $enterprise = Enterprise::where('enterprises.id', $project->enterprise_id)->first();
                $enterprise_name = $enterprise->name;

                array_push($enterprises_list, $enterprise_name);
            }

        } else {
            $projects = Project::select('projects.id', 'projects.project', 'projects.enterprise_id', 'projects.calendar_id')
                ->where('projects.project', 'like', "%$filter%")
                ->orWhere('projects.id', 'like', "%$filter%")
                ->orderBy('projects.id', 'desc')->paginate(5);

            foreach($projects as &$project){

                $enterprise = Enterprise::where('enterprises.id', $project->enterprise_id)->first();
                $enterprise_name = $enterprise->name;

                array_push($enterprises_list, $enterprise_name);

            }
        }

        return [
            'pagination' => [
                'total' => $projects->total(),
                'current_page' => $projects->currentPage(),
                'per_page' => $projects->perPage(),
                'last_page' => $projects->lastPage(),
                'from' => $projects->firstItem(),
                'to' => $projects->lastItem(),
            ],
            'projects' => $projects,
            'enterprises_list' => $enterprises_list
        ];
    }


    public function store(Request $request)
    {
        $project = new Project();
        $project->project = $request->project;
        $project->enterprise_id = $request->enterprise_id;
        $project->calendar_id = 1;

        $project->save();
        return ['status' => 'OK'];
    }

    public function update(Request $request)
    {

        $project = Project::findOrFail($request->id);
        $project->project = $request->project;
        $project->enterprise_id = $request->enterprise_id;
        $project->calendar_id = 1;


        $project->save();
        return ['status' => 'OK'];
    }

    public function delete(Request $request, $id)
    {
        $project = Project::findOrFail($id)->delete();
        return ['status' => 'OK'];
    }



    public function getProjects()
    {

        $projects = Project::select('projects.id', 'projects.project')
            ->orderBy('projects.id', 'desc')->get();
        return [
            'tasks' => $projects
        ];

    }


}
