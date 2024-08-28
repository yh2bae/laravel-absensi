<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()->name,
                'phone' => $user->profile->phone ?? null,
                'address' => $user->profile->address ?? null,
                'avatar' => $user->profile->avatar ?? null,
                'department' => $user->userDepartementPosition->departement->name ?? null,
                'position' => $user->userDepartementPosition->position->name ?? null,
                'face_embedding' => $user->faceRecognition->face_embedding ?? null,
                'image_url' => $user->faceRecognition->image_url ?? null,
 
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getUser()
    {
        try {
            $user = auth()->user();

            $user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()->name,
                'phone' => $user->profile->phone ?? null,
                'address' => $user->profile->address ?? null,
                'avatar' => $user->profile->avatar ?? null,
                'department' => $user->userDepartementPosition->departement->name ?? null,
                'position' => $user->userDepartementPosition->position->name ?? null,
                'face_embedding' => $user->faceRecognition->face_embedding ?? null,
                'image_url' => $user->faceRecognition->image_url ?? null,
            ];

            $token = request()->bearerToken();

            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil diambil',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
