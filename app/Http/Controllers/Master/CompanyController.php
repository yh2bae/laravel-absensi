<?php

namespace App\Http\Controllers\Master;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\CompanyRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class CompanyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:departement_view', only: ['index']),
            new Middleware('permission:departement_update', only: ['update']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.company.';

    }

    public function index()
    {
       $company = Company::first();

        $data = [
            'page_title' => 'Perusahaan',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'perusahaan' => ['title' => 'Perusahaan', 'url' => route('company')],
            ],
            'company' => $company,
        ];

        return view($this->path . 'index', $data);
    }

    public function update (CompanyRequest $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->update($request->all());

            return redirect()->route('company')->with('success', 'Data perusahaan berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('company')->with('error', 'Data perusahaan gagal diubah');
        }
    }
}
