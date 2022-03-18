<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // CREATE PROJECT
    public function create(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required'
        ]);

        // student id + create data
        $student_id = auth()->user()->id;

        $project = new Project();

        $project->students_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;
        $project->save();
        // send response
        return response()->json([
            'status' => 1,
            'message' => "Project has been created"
        ]);
    }

    // LIST ALL PROJECTS
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $project = Project::where('students_id', $student_id)->get();

        return response()->json([
            'status' => 1,
            "message" => "Projects",
            "data" => $project
        ]);
    }

    // LIST PROJECT BY ID
    public function single($id)
    {
        $student_id = auth()->user()->id;

        if (Project::where([
            'id' => $id,
            'students_id' => $student_id
        ])->exists()) {

            $detail = Project::where([
                'id' => $id,
                'students_id' => $student_id
            ])->first();

            return response()->json([
                'status' => 1,
                "message" => 'Project detail',
                'data' => $detail
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Project No found'
            ]);
        }
    }

    // DELETE PROJECTS
    public function destroy($id)
    {
        $student_id = auth()->user()->id;

        if (Project::where([
            'id' => $id,
            'students_id' => $student_id
        ])->exists()) {
            $project = Project::where([
                'id' => $id,
                'students_id' => $student_id
            ])->first();

            $project->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Project of that ID deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Project of that ID is not found'
            ]);
        }
    }
}
