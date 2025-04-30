<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Shakwa;
use App\Models\Suggest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShakwaController extends Controller
{


    public function AddShakwa(Request $request)
    {
        $user = $request->user();
        $Validation = Validator::make($request->all(), [
            'event_id' => 'nullable|exists:events,id',
            'task_id' => 'nullable|exists:tasks,id',
            'shakwa_title' => 'required|string',
            'shakwa_description' => 'required|string',
        ]);
        if ($Validation->fails()) {
            return response()->json($Validation->errors(), 422);
        }
        $shakwa = Shakwa::create([
            'user_id' => $user->id,
            'task_id'=>$request->task_id ?? null,
            'event_id'=>$request->event_id ?? null,
            'shakwa_title' => $request->shakwa_title,
            'shakwa_description' => $request->shakwa_description,
        ]);
        return response()->json([
            'message' => 'Shakwa added successfully',
            'shakwa' => $shakwa,
        ])->setStatusCode(201, 'Created');
    }


    public function AddSuggest(Request $request)
    {
        $user = $request->user();
        $Validation = Validator::make($request->all(), [
            'event_id' => 'nullable|exists:events,id',
            'task_id' => 'nullable|exists:tasks,id',
            'suggest_title' => 'required|string',
            'suggest_description' => 'required|string',
        ]);
        if ($Validation->fails()) {
            return response()->json($Validation->errors(), 422);
        }
        $shakwa = Suggest::create([
            'user_id' => $user->id,
            'task_id'=>$request->task_id ?? null,
            'event_id'=>$request->event_id ?? null,
            'suggest_title' => $request->suggest_title,
            'suggest_description' => $request->suggest_description,
        ]);
        return response()->json([
            'message' => 'Suggest added successfully',
            'sugeest' => $shakwa,
        ])->setStatusCode(201, 'Created');
    }


    public function getShakwa(Request $request)
    {
        $user = $request->user();
        $shakwa = Shakwa::where('user_id', $user->id)->get();
        return response()->json([
            'shakwa' => $shakwa,
        ])->setStatusCode(200, 'Success');
    }

    public function getSuggest(Request $request)
    {
        $user = $request->user();
        $shakwa = Suggest::where('user_id', $user->id)->get();
        return response()->json([
            'shakwa' => $shakwa,
        ])->setStatusCode(200, 'Success');
    }

}
