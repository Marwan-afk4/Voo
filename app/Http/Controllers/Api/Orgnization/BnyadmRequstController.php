<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\UserPaper;
use Illuminate\Http\Request;

class BnyadmRequstController extends Controller
{


    public function getBnyadmRequstList(Request $request){
        $Orgnization_id = $request->user()->id;
        $bnyadm = UserPaper::where('orgnization_id', $Orgnization_id)
            ->where('status', 'pending')
            ->with([
            'user:id,name,email,phone',
            'orgnization:id,name,email,phone',
        ])->get();
        return response()->json([
            'message' => 'Bnyadm requst list retrieved successfully',
            'data' => $bnyadm
        ]);
    }

    public function getBnyadmRequstDetails($id){
        $bnyadm = UserPaper::with([
            'user:id,name,email,phone',
            'orgnization:id,name,email,phone',
        ])->find($id);
        if ($bnyadm) {
            return response()->json([
                'message' => 'Bnyadm requst details retrieved successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }

    public function acceptBnyadmRequst($id){
        $bnyadm = UserPaper::find($id);
        if ($bnyadm) {
            $bnyadm->update(['status' => 'accepted']);
            return response()->json([
                'message' => 'Bnyadm requst accepted successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }

    public function rejectBnyadmRequst($id){
        $bnyadm = UserPaper::find($id);
        if ($bnyadm) {
            $bnyadm->update(['status' => 'rejected']);
            return response()->json([
                'message' => 'Bnyadm requst rejected successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }
}
