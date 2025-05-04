<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shakwa;
use App\Models\Suggest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function getUsers(){
        $users = User::where('role', 'user')
        ->with(['country:name,id', 'city:name,id', 'user_papers','orgnization'])->get();
        $data =[
            'users' => $users,
        ];
        return response()->json($data, 200);
    }

    public function getUser($id){
        $user = User::with(['country:name,id', 'city:name,id', 'user_papers','orgnization'
        , 'user_events', 'user_tasks'])->findOrFail($id);
        $data =[
            'user' => $user,
        ];
        return response()->json($data, 200);
    }

    public function addUser(Request $request){
        $validation = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:8',
            'bithdate' => 'nullable|date',
            'gender' => 'required|in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'birth' => $request->bithdate,
            'gender' => $request->gender,
            'role' => 'user',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'bithdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::findOrFail($id);
        $user->update([
            'country_id' => $request->country_id?? $user->country_id,
            'city_id' => $request->city_id?? $user->city_id,
            'name' => $request->name?? $user->name,
            'email' => $request->email?? $user->email,
            'phone' => $request->phone?? $user->phone,
            'birth' => $request->bithdate?? $user->bith,
            'gender' => $request->gender?? $user->gender,
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    public function getShakawy(){
        $shakawy = Shakwa::with(['user:id,name'])->get();
        return response()->json([
            'shakawy' => $shakawy,
        ]);
    }

    public function getSuggests(){
        $suggest = Suggest::with(['user:id,name','event','task'])->get();
        return response()->json([
            'Suggests' => $suggest,
        ]);
    }
}
