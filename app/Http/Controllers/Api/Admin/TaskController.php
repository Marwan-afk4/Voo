<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use Image;

    public function getTasks(){
        $tasks = Task::with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
            'task_requirments:id,task_id,requirment',
            'task_benfits:id,task_id,benfit',
            'orgnization'
            ])->get();
        $data =[
            'tasks' => $tasks,
        ];
        return response()->json($data, 200);
    }

    public function getTaskById($id){
        $task = Task::with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
            'task_requirments:id,task_id,requirment',
            'task_benfits:id,task_id,benfit',
        ])->find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json(['task'=>$task], 200);
    }

    public function addTask(Request $request){
        $Validation = Validator::make($request->all(), [
            'orgnization_id'=>'required|exists:users,id',
            'name'=>'required|string|max:255',
            'from_zone_id'=>'required|exists:zones,id',
            'to_zone_id'=>'required|exists:zones,id',
            'description'=>'required|string|max:255',
            'date'=>'required|date',
            'start_time'=>'required',
            'number_of_voo_needed'=>'required|integer',
            'status'=>'required|in:active,inactive',
            'image'=>'required',
            'location'=>'nullable',
            'requirments'=>'nullable|array',
            'requirments.*'=>'required|string|max:255',
            'benfits'=>'nullable|array',
            'benfits.*'=>'required|string|max:255',
        ]);
        if($Validation->fails()){
            return response()->json(['message'=>$Validation->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $task = Task::create([
                'orgnization_id'=>$request->orgnization_id,
                'name'=>$request->name,
                'from_zone_id'=>$request->from_zone_id,
                'to_zone_id'=>$request->to_zone_id,
                'description'=>$request->description,
                'date'=>$request->date,
                'start_time'=>$request->start_time,
                'number_of_voo_needed'=>$request->number_of_voo_needed,
                'status'=>$request->status,
                'image'=>$this->storeBase64Image($request->image, 'tasks/image'),
                'location'=>$request->location,
            ]);
            if ($request->has('requirments')) {
                foreach ($request->requirments as $requirment) {
                    $task->task_requirments()->create([
                        'task_id' => $task->id,
                        'requirment' => $requirment
                    ]);
                }
            }
            if ($request->has('benfits')) {
                foreach ($request->benfits as $benfit) {
                    $task->task_benfits()->create([
                        'task_id' => $task->id,
                        'benfit' => $benfit
                    ]);
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Error in creating task'], 500);
        }
        return response()->json(['message'=>'Task created successfully'], 200);
    }

    public function updateTask(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'name'=>'nullable|string|max:255',
            'from_zone_id'=>'nullable|exists:zones,id',
            'to_zone_id'=>'nullable|exists:zones,id',
            'description'=>'nullable|string|max:255',
            'date'=>'nullable|date',
            'start_time'=>'nullable',
            'number_of_voo_needed'=>'nullable|integer',
            'status'=>'nullable|in:active,inactive',
            'image'=>'nullable',
            'location'=>'nullable',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()], 422);
        }
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message'=>'Task not found'], 404);
        }
        $task->update([
            'name'=>$request->name ?? $task->name,
            'from_zone_id'=>$request->from_zone_id ?? $task->from_zone_id,
            'to_zone_id'=>$request->to_zone_id ?? $task->to_zone_id,
            'description'=>$request->description ?? $task->description,
            'date'=>$request->date ?? $task->date,
            'start_time'=>$request->start_time ?? $task->start_time,
            'number_of_voo_needed'=>$request->number_of_voo_needed ?? $task->number_of_voo_needed,
            'status'=>$request->status ?? $task->status,
            'image'=> $request->image ? $this->storeBase64Image($request->image, 'tasks/image') : $task->image,
            'location'=>$request->location ?? $task->location,
        ]);
        return response()->json(['message'=>'Task updated successfully'], 200);
    }

    public function deleteTask($id){
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message'=>'Task not found'], 404);
        }
        $task->delete();
        return response()->json(['message'=>'Task deleted successfully'], 200);
    }
}
