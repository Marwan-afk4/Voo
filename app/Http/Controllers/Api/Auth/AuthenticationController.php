<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Image;
use App\Mail\EmailVerificationCode;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    use Image;

    public function register(Request $request)
{
    // Validate input
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

    // Check for existing user by email or phone
    $userExists = User::where('email', $request->email)
                      ->orWhere('phone', $request->phone)
                      ->first();

    $code = rand(100000, 999999); // Email verification code

    // If user exists and is not verified, update the record
    if ($userExists) {
        if ($userExists->is_email_verified == false) {
            $userExists->update([
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'bithdate' => $request->bithdate,
                'gender' => $request->gender,
                'role' => 'user',
                'email_verification_code' => $code,
                'is_email_verified' => false,
                'account_status' => 'inactive',
            ]);

            Mail::to($userExists->email)->send(new EmailVerificationCode($code, $userExists->name));

            return response()->json([
                'message' => 'Go and check your email to verify your account',
            ]);
        } elseif($userExists->is_email_verified == true) {
            return response()->json([
                'message' => 'This email or phone number is already registered',
            ], 409);
        }
    }

    $user = User::create([
        'country_id' => $request->country_id,
        'city_id' => $request->city_id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'bithdate' => $request->bithdate,
        'gender' => $request->gender,
        'role' => 'user',
        'email_verification_code' => $code,
        'is_email_verified' => false,
        'account_status' => 'inactive',
    ]);

    Mail::to($user->email)->send(new EmailVerificationCode($code, $user->name));

    return response()->json([
        'message' => 'Go and check your email to verify your account',
    ]);
}


    public function verifyEmail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->email_verification_code !== $request->code) {
            return response()->json(['error' => 'Invalid verification code.'], 400);
        }

        $user->update([
            'is_email_verified' => true,
            'email_verification_code' => null,
            'account_status' => 'active',
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json(['message' => 'Email verified successfully.',
            'user' => $user,
            'token' => $token,
        ]);
    }



    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'nullable|email|exists:users,email',
            'phone' => 'nullable|exists:users,phone',
            'password' => 'required|min:8',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User successfully logged in',
            'user' => $user,
            'token' => $token,
        ]);
    }





    public function forgetPassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        $resetCode = rand(100000, 999999);

        $user->update([
            'email_verification_code' => $resetCode,
            'is_email_verified' => false,
        ]);

        Mail::to($user->email)->send(new ForgotPasswordMail($resetCode, $user->name));

        return response()->json([
            'message' => 'A reset code has been sent to your email address.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email'=>'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }
        $user = User::where('email', $request->email)->first();

        // if ($user->email_verification_code !== $request->code) {
        //     return response()->json(['error' => 'Invalid verification code.'], 400);
        // }
        $user->update([
            'password' => Hash::make($request->password),
            'email_verification_code' => null,
            'is_email_verified' => true,
        ]);
        return response()->json([
            'message' => 'Password reset successfully.',
        ]);
    }


    public function userProfile(Request $request)
    {
        $user = $request->user()->with([
            'country:id,name',
            'city:id,name,country_id',
        ])->find($request->user()->id);
        return response()->json([
            'message' => 'User profile retrieved successfully',
            'user' => $user,
        ]);
    }

    public function editUserProfile(Request $request){
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'password' => 'nullable|min:8',
            'bithdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'avatar_image'=> 'nullable'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user->update([
            'country_id' => $request->country_id?? $user->country_id,
            'city_id' => $request->city_id?? $user->city_id,
            'name' => $request->name?? $user->name,
            'email' => $request->email?? $user->email,
            'phone' => $request->phone?? $user->phone,
            'birth' => $request->bithdate?? $user->bithdate,
            'gender' => $request->gender?? $user->gender,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'avatar_image' => $request->avatar_image ? $this->storeBase64Image($request->avatar_image, 'users/image') : $user->avatar_image,
        ]);
        return response()->json([
            'message' => 'User profile updated successfully',
            'user' => $user,
        ]);
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'User successfully logged out',
        ]);
    }
}
