<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkPermitApiRequest;

class WorkPermitController extends Controller
{
    public function store (WorkPermitApiRequest $request)
    {
        try {
            $request->validated();
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name_user = str_replace(' ', '_', strtolower(auth()->user()->name));
                $fileName = 'work_permit_'. $name_user . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/work-permit', $fileName);
            }

            $workPermit = auth()->user()->workPermits()->create([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'file' => $fileName ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membuat izin kerja',
                'data' => $workPermit,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat izin kerja',
            ], 500);
        }
    }
 
}
