<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PositionRequest;
use App\Models\Departement;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class PositionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:position_view', only: ['index']),
            new Middleware('permission:position_create', only: ['store']),
            new Middleware('permission:position_update', only: ['update']),
            new Middleware('permission:position_show', only: ['show']),
            new Middleware('permission:position_delete', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.position.';

    }

    public function index(Request $request, DataTables $dataTables)
    {

        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $departements = Departement::all();

        $data = [
            'page_title' => 'Posisi',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'posisi' => ['title' => 'Posisi', 'url' => route('positions')],
            ],
            'departements' => $departements,
        ];

        return view($this->path . 'index', $data);
    }

    public function store(PositionRequest $request)
    {
        try {
            $request->validated();

            Position::create([
                'departement_id' => $request->departement_id,
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Posisi baru berhasil ditambahkan',
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
            $position = Position::with('departement')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $position,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(PositionRequest $request, $id)
    {
        try {
            $request->validated();

            $position = Position::findOrFail($id);
            $position->update([
                'departement_id' => $request->departement_id,
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Posisi berhasil diubah',
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
            $position = Position::findOrFail($id);
            $position->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Posisi berhasil dihapus',
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
        $query = Position::query()->with('departement');

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 0;
                $pageStart = request()->input('start', 0);
                return ++$no + $pageStart . '.';
            })
            ->addColumn('department', function ($item) {
                return $item->departement ? $item->departement->name : '-';
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function positionWithDepartement($id)
    {
        try {
            $position = Position::where('departement_id', $id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $position,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }
}
