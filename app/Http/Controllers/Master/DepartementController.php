<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DepartementRequest;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class DepartementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:departement_view', only: ['index']),
            new Middleware('permission:departement_create', only: ['store']),
            new Middleware('permission:departement_update', only: ['update']),
            new Middleware('permission:departement_show', only: ['show']),
            new Middleware('permission:departement_delete', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.departement.';

    }

    public function index(Request $request, DataTables $dataTables)
    {

        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $data = [
            'page_title' => 'Departmen',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'departemen' => ['title' => 'Departemen', 'url' => route('departements')],
            ],
        ];

        return view($this->path . 'index', $data);
    }

    public function store(DepartementRequest $request)
    {
        try {
            $request->validated();

            Departement::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Departement baru berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $departement = Departement::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $departement,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(DepartementRequest $request, $id)
    {
        try {
            $request->validated();

            $departement = Departement::findOrFail($id);
            $departement->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Departement berhasil diubah',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diubah',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $departement = Departement::findOrFail($id);
            $departement->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Departement berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }

    protected function datatables(DataTables $dataTables)
    {
        $query = Departement::query();

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 0;
                $pageStart = request()->input('start', 0);
                return ++$no + $pageStart . '.';
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
