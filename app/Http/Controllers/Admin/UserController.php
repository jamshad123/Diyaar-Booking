<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function List()
    {
        return view('admin.user.list');
    }

    public function DataTable(Request $request)
    {
        $data = $request->all();
        $based_on = $data['based_on'] ?? 'start_date';
        $datas = new User;
        $datas = $datas->when($data['status'] ?? '', function ($q, $value) {
            return $q->where('status', $value);
        });
        $datas = $datas->when($data['status_id'] ?? '', function ($q, $value) {
            return $q->where('status_id', $value);
        });

        return Datatables::of($datas)
        ->editColumn('name', function ($value) {
            return "<a href='".route('User::View', $value->id)."'>$value->name</a>";
        })
        ->addIndexColumn()
        ->rawColumns(['name'])
        ->make(true);
    }

    public function View($id)
    {
        return view('admin.user.view', compact('id'));
    }

    public function collection()
    {
        return view('admin.user.collection');
    }

    public function collectionDataTable(Request $request)
    {
        $data = $request->all();
        $datas = new DailyCollection;
        $datas = $datas->when($data['from_date'] ?? '', function ($q, $value) {
            return $q->where('opening_time', '>', date('Y-m-d H:i:s', strtotime($value)));
        });
        $datas = $datas->when($data['to_date'] ?? '', function ($q, $value) {
            return $q->where('opening_time', '<', date('Y-m-d H:i:s', strtotime($value)));
        });
        $datas = $datas->when($data['user_id'] ?? '', function ($q, $value) {
            return $q->where('user_id', $value);
        });

        return Datatables::of($datas)
        ->editColumn('user_id', function ($value) {
            return "<a href='".route('User::View', $value->user_id)."'>".$value->user->name.'</a>';
        })
        ->editColumn('opening_time', function ($value) {
            return systemDateTime($value->opening_time);
        })
        ->editColumn('opening_balance', function ($value) {
            return currency($value->opening_balance);
        })
        ->editColumn('closing_time', function ($value) {
            return systemDateTime($value->closing_time);
        })
        ->editColumn('closing_balance', function ($value) {
            return currency($value->closing_balance);
        })
        ->addIndexColumn()
        ->rawColumns(['user_id'])
        ->make(true);
    }
}
