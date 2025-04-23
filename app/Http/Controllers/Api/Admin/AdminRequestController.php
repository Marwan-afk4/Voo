<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{


    public function getAllRequest(){
        $request = ModelsRequest::with(['user:id,name,email','task:id,name','event:id,name','orgnization:id,name'])->get();
        return response()->json([
            'requests' => $request,
        ], 200);
    }

    public function getRequestById($id){
        $request = ModelsRequest::with(['user:id,name,email','task:id,name','event:id,name','orgnization:id,name'])->find($id);
        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        return response()->json(['request'=>$request], 200);
    }

    public function acceptRequest(Request $request, $id){
        $requestData = ModelsRequest::find($id);
        if (!$requestData) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        $requestData->status = 'accepted';
        $requestData->save();
        return response()->json(['message' => 'Request status updated successfully'], 200);
    }

    public function deleteRequest($id){
        $request = ModelsRequest::find($id);
        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        $request->delete();
        return response()->json(['message' => 'Request deleted successfully'], 200);
    }

    public function rejectRequest(Request $request, $id){
        $requestData = ModelsRequest::find($id);
        if (!$requestData) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        $requestData->status = 'rejected';
        $requestData->save();
        return response()->json(['message' => 'Request status updated successfully'], 200);
    }
}
