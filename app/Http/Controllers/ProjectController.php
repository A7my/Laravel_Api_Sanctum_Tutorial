<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects(){
        $projects = Project::where('user_id' , auth()->user()->id)->get();
        return response()->json([
            'status' => 1 ,
            'My_data'  => $projects,
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $project = new Project;
        $project->project_name = $request->name;
        $project->project_description = $request->description;
        $project->user_id = auth()->user()->id;
        $project->save();

        return response()->json('you created a new project');
    }

    public function single($id){
        if(Project::where('id' , $id)->exists()){
            if(Project::where(['id'=> $id , 'user_id' => auth()->user()->id])->exists()){
                return response()->json([
                    'status' => 1 ,
                    "data" => Project::where([
                        'id'=> $id ,
                        'user_id' => auth()->user()->id
                    ])->first(),
                ]);
            }else{
                return response()->json('you are Not Allowed To check this project');
            }
        }else{
            return response()->json([
                'the project Not Found',
            ]);
        }

        // $user_id = auth()->user()->id;
        // if(Project::where('id' , $id)->exists()){
        //     if(Project::where(['id'=>$id , 'user_id' => $user_id])->exists()){
        //         $project = Project::find($id);
        //         return response()->json([
        //             'status' => 1 ,
        //             'data' => $project
        //         ]);
        //     }else{
        //         echo "You Are Not Allowed to check this project";
        //     }
        // }else{
        //     echo "The Project Not Found";
        // }

    }

    public function delete($id){
        $user_id = auth()->user()->id;

        if(Project::where('id' , $id)->exists()){
            if(Project::where(['id'=> $id , 'user_id'=>$user_id])->exists()){
                Project::find($id)->delete();
                return response()->json('you have deleted your #' . $id . ' Project');
            }else{
                return response()->json('you are Not Allowed To delete this projects');
            }
        }else{
            return response()->json('the project not found');
        }
    }

    public function search($name){
        $project = Project::where('project_name' , 'like' , '%'.$name.'%')->get();
        return response()->json([
            'data' => $project
        ]);
    }
}
