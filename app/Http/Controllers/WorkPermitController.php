<?php

namespace App\Http\Controllers;

use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WorkPermitController extends Controller
{

    public function __construct()
    {
        $this->path = 'pages.work-permit.';
    }

    public function index(Request $request, DataTables $dataTables)
    {

        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $data = [
            'page_title' => 'Izin Kerja',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'work-permit' => ['title' => 'Izin Kerja', 'url' => route('work-permit')],
            ],
            'statuses' => WorkPermit::getStatuses(),
        ];

        return view($this->path . 'index', $data);
    }

    public function show($id)
    {
        try {
            $workPermit = WorkPermit::findOrFail($id);
            $data = [
                'id' => $workPermit->id,
                'name' => $workPermit->user->name,
                'email' => $workPermit->user->email,
                'avatar' => $workPermit->user->profile->avatar ?? asset('assets/images/users/user-dummy-img.jpg'),
                'start_date' => date('d M Y', strtotime($workPermit->start_date)),
                'end_date' => date('d M Y', strtotime($workPermit->end_date)),
                'days' => date_diff(date_create($workPermit->start_date), date_create($workPermit->end_date))->format('%a'),
                'phone' => $workPermit->user->profile->phone ?? '-',
                'address' => $workPermit->user->profile->address ?? '-',
                'department' => $workPermit->user->userDepartementPosition->departement->name ?? '-',
                'position' => $workPermit->user->userDepartementPosition->position->name ?? '-',
                'status' => $workPermit->status,
                'reason' => $workPermit->reason,
                'file' => $workPermit->file,
                'created_at' => date('d M Y H:i:s', strtotime($workPermit->created_at)),
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $data,
            ], 200);
            return view($this->path . 'show', $data);
        } catch (\Exception $e) {
            return redirect()->route('work-permit')->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $workPermit = WorkPermit::findOrFail($id);
            $workPermit->status = $request->status;
            $workPermit->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    protected function datatables(DataTables $dataTables)
    {
        $query = WorkPermit::with('user')
            ->join('users', 'work_permits.user_id', '=', 'users.id')
            ->select('work_permits.*', 'users.name as user_name');

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 0;
                $pageStart = request()->input('start', 0);
                return ++$no + $pageStart . '.';
            })
            ->editColumn('name', function ($item) {
                $item->avatar = $item->user->profile->avatar ?? asset('assets/images/users/user-dummy-img.jpg');
                $item->name = $item->user->name;
                return view($this->path . 'components.row.name', compact('item'));
            })
            ->editColumn('date', function ($item) {
                $start_date = date('d M Y', strtotime($item->start_date));
                $end_date = date('d M Y', strtotime($item->end_date));
                return $start_date . ' - ' . $end_date;
            })
            ->addColumn('status', function ($item) {
                return view($this->path . 'components.row.status', compact('item'));
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->orderColumn('date', 'start_date $1')
            ->orderColumn('status', 'status $1')
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%");
                });
            })
            ->filterColumn('date', function ($query, $keyword) {
                $query->where('start_date', 'like', "%$keyword%")
                    ->orWhere('end_date', 'like', "%$keyword%");
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
