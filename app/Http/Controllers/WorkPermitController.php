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
            'page_title' => 'Work Permit',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'work-permit' => ['title' => 'Work Permit', 'url' => route('work-permit')],
            ],
        ];

        return view($this->path . 'index', $data);
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
