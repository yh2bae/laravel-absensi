<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function getCompany()
    {
        try {
            $company = Company::first();

            return response()->json([
                'status' => 'success',
                'message' => 'Data perusahaan berhasil diambil',
                'data' => $company,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
