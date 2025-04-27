<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use Image;

    public function getOrgnizationTasks(Request $request){
        $orgnizationId = $request->user()->id;
        $tasks = Task::where('orgnization_id', $orgnizationId)
        ->with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
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
        ])->find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json(['task'=>$task], 200);
    }

    public function addTask(Request $request){
        $orgnizationId = $request->user()->id;
        $Validation = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'from_zone_id'=>'required|exists:zones,id',
            'to_zone_id'=>'required|exists:zones,id',
            'description'=>'required|string|max:255',
            'date'=>'required|date',
            'start_time'=>'required',
            'number_of_voo_needed'=>'required|integer',
            'status'=>'required|in:active,inactive',
            'image'=>'required',
        ]);
        if($Validation->fails()){
            return response()->json(['message'=>$Validation->errors()], 422);
        }
        $task = Task::create([
            'orgnization_id'=>$orgnizationId,
            'name'=>$request->name,
            'from_zone_id'=>$request->from_zone_id,
            'to_zone_id'=>$request->to_zone_id,
            'description'=>$request->description,
            'date'=>$request->date,
            'start_time'=>$request->start_time,
            'number_of_voo_needed'=>$request->number_of_voo_needed,
            'status'=>$request->status,
            'image'=>$this->storeBase64Image($request->image, 'Orgnization/tasks/image'),
        ]);
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
            'image'=> $request->image ? $this->storeBase64Image($request->image, 'Orgnization/tasks/image') : $task->image,
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

    public function letTaskActive($id){
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message'=>'Task not found'], 404);
        }
        $task->update([
            'status'=>'active',
        ]);
        return response()->json(['message'=>'Task activated successfully'], 200);
    }
    public function letTaskInactive($id){
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message'=>'Task not found'], 404);
        }
        $task->update([
            'status'=>'inactive',
        ]);
        return response()->json(['message'=>'Task deactivated successfully'], 200);
    }
}
