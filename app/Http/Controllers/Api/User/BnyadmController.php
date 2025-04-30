<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\UserPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BnyadmController extends Controller
{
    use Image;

    public function BeBnyadm(Request $request){
        $user_id = $request->user()->id;
        $Validation = Validator::make($request->all(), [
            'orgnization_id'=>'required|exists:users,id',
            'front_identity'=>'required|string',
            'back_identity'=>'required|string',
            'selfi_image'=>'required|string',
            'orgnization_paper'=>'required|string',
        ]);
        if ($Validation->fails()) {
            return response()->json($Validation->errors(), 422);
        }
        $create = UserPaper::create([
            'user_id' => $user_id,
            'orgnization_id' => $request->orgnization_id,
            'front_identity' =>$this->storeBase64Image($request->front_identity, 'user/Front_identity/user_papers'),
            'back_identity' =>$this->storeBase64Image($request->back_identity, 'user/Back/user_papers'),
            'selfi_image' =>$this->storeBase64Image($request->selfi_image, 'user/Selfi/user_papers'),
            'orgnization_paper' =>$this->storeBase64Image($request->orgnization_paper, 'user/Orgnization_paper/user_papers'),
        ]);
        return response()->json([
            'message' => 'Bnyadm added successfully',
            'bnyadm' => $create,
        ])->setStatusCode(201, 'Created');
    }
}
