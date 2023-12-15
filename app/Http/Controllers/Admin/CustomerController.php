<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->Customer = new Customer;
    }

    public function List()
    {
        return view('admin.customer.list');
    }

    public function DataTable(Request $request)
    {
        $data = $request->all();
        $datas = new Customer;
        $datas = $datas->when($data['gender'] ?? '', function ($q, $value) {
            return $q->where('gender', $value);
        });
        $datas = $datas->when($data['document_type'] ?? '', function ($q, $value) {
            return $q->where('document_type', $value);
        });
        $datas = $datas->when($data['country'] ?? '', function ($q, $value) {
            return $q->where('country', $value);
        });
        $datas = $datas->when($data['customer_type'] ?? '', function ($q, $value) {
            return $q->where('customer_type', $value);
        });

        return Datatables::of($datas)
        ->editColumn('name', function ($value) {
            return "<a href='".route('Customer::View', $value->id)."'>$value->name</a>";
        })
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
        return view('admin.customer.view', compact('id'));
    }

    public function GetCustomerDropDownList(Request $request)
    {
        return $this->Customer->getDropDownList($request->all());
    }
}
