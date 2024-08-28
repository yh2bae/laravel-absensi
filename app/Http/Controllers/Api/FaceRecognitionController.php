<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaceRecognitionRequest;
use Illuminate\Support\Facades\Auth;

class FaceRecognitionController extends Controller
{
    public function update(FaceRecognitionRequest $request)
    {
        try {
            $user = Auth::user();
    
            $request->validated();
    
            $faceRecognition = $user->faceRecognition;
    
            if ($faceRecognition) {
                $faceRecognition->update([
                    'face_embedding' => $request->face_embedding,
                ]);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Face recognition berhasil diupdate',
                    'data' => $faceRecognition,
                ]);
            } else {
                $user->faceRecognition()->create([
                    'face_embedding' => $request->face_embedding,
                ]);
    
                // Mengambil ulang data faceRecognition setelah dibuat
                $faceRecognition = $user->fresh()->faceRecognition;
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Face recognition berhasil dibuat',
                    'data' => $faceRecognition,
                ]);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    

}
