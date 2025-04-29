<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestListController extends Controller
{


    public function PendingApproved(Request $request){
        $user = $request->user();
        $pendingRequest = ModelsRequest::where('user_id', $user->id)
        ->where('status', 'pending')
        ->with([
            'event',
            'event.event_benfits',
            'event.event_requirments',
            'task',
            'task.task_benfits',
            'task.task_requirments',
            'orgnization:id,name,email'
        ])
        ->get();
        $acceptedRequest = ModelsRequest::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->with([
            'event',
            'event.event_benfits',
            'event.event_requirments',
            'task',
            'task.task_benfits',
            'task.task_requirments',
            'orgnization:id,name,email'
        ])
        ->get();

        return response()->json([
            'pendingRequest' => $pendingRequest,
            'acceptedRequest' => $acceptedRequest,
        ])->setStatusCode(200, 'Success');
    }
}
