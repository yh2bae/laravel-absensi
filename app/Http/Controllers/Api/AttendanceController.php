<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {

        try {
            $user = Auth::user();

            $query = Attendance::where('user_id', $user->id);

            if ($request->has('date')) {
                $query->where('date', $request->date);
            }

            $attendances = $query->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Get attendance success',
                'data' => $attendances,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }

    }

    public function checkin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

            $user = Auth::user();

            $attendance = Attendance::create([
                'user_id' => $user->id,
                'date' => date('Y-m-d'),
                'time_in' => date('H:i:s'),
                'latlon_in' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Checkin success',
                'data' => $attendance,
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

    public function checkout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

            $user = Auth::user();

            $attendance = Attendance::where('user_id', $user->id)
                ->where('date', date('Y-m-d'))
                ->first();

            if (!$attendance) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Checkin not found',
                ], 404);
            }

            $attendance->update([
                'time_out' => date('H:i:s'),
                'latlon_out' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout success',
                'data' => $attendance,
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

    public function isCheckedin(Request $request)
    {
        try {
            $user = Auth::user();

            $attendance = Attendance::where('user_id', $user->id)
                ->where('date', date('Y-m-d'))
                ->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Get checkin status success',
                'data' => [
                    'is_checkin' => $attendance ? true : false,
                    'is_checkout' => $attendance && $attendance->time_out ? true : false,
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
