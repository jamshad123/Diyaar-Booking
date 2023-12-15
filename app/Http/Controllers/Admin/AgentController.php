<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->Agent = new Agent;
    }

    public function List()
    {
        return view('admin.agent.List');
    }

    public function DataTable(Request $request)
    {
        $data = $request->all();
        $datas = new Agent;
        $datas = $datas->when($data['status_id'] ?? '', function ($q, $value) {
            return $q->where('status_id', $value);
        });

        return Datatables::of($datas)
        ->editColumn('name', function ($value) {
            return $value->name;
        })
        ->addColumn('action', function ($value) {
            $return = '<button table_id="'.$value->id.'" class="btn btn-sm text-primary btn-icon item-edit edit"><i class="bx bxs-edit"></i></button>';

            return $return;
        })
        ->addIndexColumn()
        ->rawColumns(['name', 'action'])
        ->make(true);
    }

    public function View($id)
    {
        return view('admin.agent.view', compact('id'));
    }

    public function GetAgentDropDownList(Request $request)
    {
        return $this->Agent->getDropDownList($request->all());
    }
}
