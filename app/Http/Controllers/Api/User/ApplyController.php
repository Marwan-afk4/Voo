<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplyController extends Controller
{


    public function applyForTask(Request $request,$taskId){
        $user_id = $request->user()->id;
        
    }
}
