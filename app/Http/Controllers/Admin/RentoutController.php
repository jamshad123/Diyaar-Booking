<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Facades\Permissions;
use App\Models\Checkout;
use App\Models\CheckoutPayment;
use App\Models\Rentout;
use App\Models\Settings;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RentoutController extends Controller
{
    public function List($status = null, $flag = null)
    {
        return view('admin.rentout.list', compact('status', 'flag'));
    }

    public function DataTable(Request $request)
    {
        $data = new Rentout;
        $data = $data->when(request('start_date') ?? '', function ($q, $value) {
            switch (request('based_on')) {
                case 'check_in_date':
                return $q->whereDate('check_in_date', '>=', date('Y-m-d', strtotime($value)));
                break;
                case 'check_out_date':
                return $q->whereDate('check_out_date', '>=', date('Y-m-d', strtotime($value)));
                break;
            }
        });
        $data = $data->when(request('end_date') ?? '', function ($q, $value) {
            switch (request('based_on')) {
                case 'check_in_date':
                return $q->whereDate('check_in_date', '<=', date('Y-m-d', strtotime($value)));
                break;
                case 'check_out_date':
                return $q->whereDate('check_out_date', '<=', date('Y-m-d', strtotime($value)));
                break;
            }
        });
        $data = $data->when(request('room_id') ?? '', function ($q, $value) {
            return $q->whereHas('rentoutRooms', function ($q) {
                return $q->where('rentout_rooms.room_id', request('room_id'));
            });
        });
        $data = $data->when(request('type') ?? '', function ($q, $value) {
            return $q->whereHas('rentoutRooms', function ($p) {
                return $p->whereHas('room', function ($r) {
                    return $r->where('rooms.type', request('type'));
                });
            });
        });
        $data = $data->when(request('building_id') ?? '', function ($q, $value) {
            return $q->where('building_id', $value);
        });
        $data = $data->when(request('customer_id') ?? '', function ($q, $value) {
            return $q->where('customer_id', request('customer_id'));
        });
        $data = $data->when(request('agent_id') ?? '', function ($q, $value) {
            return $q->where('agent_id', $value);
        });
        $data = $data->when(request('status') ?? '', function ($q, $value) {
            if($value == Rentout::Pending) {
                return $q->whereIn('status', [Rentout::Pending, Rentout::Rejected]);
            }

            return $q->where('status', $value);
        });
        $data = $data->when(request('statuses') ?? [], function ($q, $value) {
            return $q->whereIn('statuses', $value);
        });
        $advance_amount = $data->sum('advance_amount');
        // $data = $data->select(
        //     'rentouts.id',
        //     'rentout_rooms.id',
        //     'rentout_rooms.rentout_id',
        //     'rentout_rooms.customer_id',
        //     'rentout_rooms.room_id',
        //     'rentout_rooms.check_in_date',
        //     'rentout_rooms.check_out_date',
        //     'rentout_rooms.amount',
        //     'rentout_rooms.status',
        // );

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('customer_id', function ($value) {
            $href = '#';
            if(Permissions::Allow('Booking.View')) {
                $href = route('Rentout::view', $value->id);
            }

            return "<a href='".$href."'>".$value->customer->full_name.'</a>';
        })
        ->addColumn('mobile', function ($value) {
            return $value->customer->mobile;
        })
        ->editColumn('check_in_date', function ($value) {
            return systemDate($value->check_in_date);
        })
        ->editColumn('check_out_date', function ($value) {
            return systemDate($value->check_out_date);
        })
        ->editColumn('advance_amount', function ($value) {
            return currency($value->advance_amount);
        })
        ->addColumn('action', function ($value) {
            $return = '';
            if(Permissions::Allow('Booking.Edit')) {
                $return = "<a href='".route('Rentout::edit', $value->id)."'><i title='Edit' class='bx bx-sm bxs-edit'></i></a>";
            }
            if($value->status == Rentout::Pending) {
                if(Permissions::Allow('BookedPending.Approve')) {
                    $return .= "&nbsp;&nbsp;&nbsp;<a href='".route('Rentout::pending', $value->id)."' ><i title='Pending' class='bx bx-sm bx-check-double'></i></a>";
                }
            } else {
                if($value->status == Rentout::Booked) {
                    if(Permissions::Allow('Checkin.Create')) {
                        $return .= "&nbsp;&nbsp;&nbsp;<a href='".route('Rentout::checkin', $value->id)."' ><i title='Check In' class='bx bx-sm bx-exit'></i></a>";
                    }
                }
            }
            if($value->status == Rentout::CheckIn) {
                if(Permissions::Allow('Checkout.Create')) {
                    $return .= "&nbsp;&nbsp;&nbsp;<a href='".route('Rentout::single_checkout', $value->id)."' ><i title='Check Out' class='bx bx-sm bxs-exit'></i></a>";
                }
            }
            // $return .= "<a class='text-end' href='".route('Rentout::print', $value->id)."' target='_blank'><i class='bx btn-info bxs-printer'></i></a>";
            $return .= "&nbsp;&nbsp;&nbsp;<a class='text-end' title='Contract Print' href='".route('Rentout::bookingContractPrint', $value->id)."' target='_blank'><i class='bx bx-sm bx-printer'></i></a>";
            $return .= "&nbsp;&nbsp;&nbsp;<a class='text-end' title='Summary Print' href='".route('Rentout::bookingSummaryPrint', $value->id)."' target='_blank'><i class='bx bx-sm bxs-printer'></i></a>";

            return $return;
        })
        ->rawColumns(['action', 'customer_id'])
        ->with('advance_amount', currency($advance_amount))
        ->make(true);
    }

    public function CheckoutDataTable(Request $request)
    {
        $data = $request->all();
        $based_on = $data['based_on'] ?? 'start_date';
        $datas = new Checkout;
        $datas = $datas->when($data['start_date'] ?? '', function ($q, $value) {
            return $q->where('checkouts.created_at', '>=', date('Y-m-d', strtotime($value)));
        });
        $datas = $datas->when($data['end_date'] ?? '', function ($q, $value) {
            return $q->where('checkouts.created_at', '<=', date('Y-m-d', strtotime($value)));
        });
        $datas = $datas->when($data['building_id'] ?? '', function ($q, $value) {
            return $q->where('checkouts.building_id', $value);
        });
        $datas = $datas->when($data['customer_id'] ?? '', function ($q, $value) {
            return $q->where('checkouts.customer_id', request('customer_id'));
        });
        $total = $datas->sum('checkouts.total');
        $tax = $datas->sum('checkouts.tax');
        $special_discount_amount = $datas->sum('checkouts.special_discount_amount');
        $additional_charges = $datas->sum('checkouts.additional_charges');
        $grand_total = $datas->sum('checkouts.grand_total');
        $advance_amount = $datas->sum('checkouts.advance_amount');
        $paid = $datas->sum('checkouts.paid');
        $balance = $datas->sum('checkouts.balance');
        // $datas = $datas->select(
        //     'rentout_rooms.id',
        //     'rentout_rooms.rentout_id',
        //     'rentout_rooms.customer_id',
        //     'rentout_rooms.room_id',
        //     'rentout_rooms.check_in_date',
        //     'rentout_rooms.check_out_date',
        //     'rentout_rooms.amount',
        //     'rentout_rooms.status',
        // );
        return Datatables::of($datas)
        ->addIndexColumn()
        ->addColumn('customer_id', function ($value) {
            $href = '#';
            if(Permissions::Allow('Booking.View')) {
                $href = route('Rentout::view', $value->rentout_id);
            }

            return "<a href='".$href."'>".$value->customer->full_name.'</a>';
        })
        ->addColumn('mobile', function ($value) {
            return $value->customer->mobile;
        })
        ->editColumn('created_at', function ($value) {
            return systemDate($value->created_at);
        })
        ->editColumn('total', function ($value) {
        return currency($value->total);
        })
        ->editColumn('tax', function ($value) {
        return currency($value->tax);
        })
        ->editColumn('special_discount_amount', function ($value) {
        return currency($value->special_discount_amount);
        })
        ->editColumn('additional_charges', function ($value) {
        return currency($value->additional_charges);
        })
        ->editColumn('grand_total', function ($value) {
        return currency($value->grand_total);
        })
        ->editColumn('advance_amount', function ($value) {
        return currency($value->advance_amount);
        })
        ->editColumn('paid', function ($value) {
        return currency($value->paid);
        })
        ->editColumn('balance', function ($value) {
        return currency($value->balance);
        })
        ->addColumn('action', function ($value) {
            $return = '';
            if(Permissions::Allow('Checkout.Edit')) {
                $return = "<a href='".route('Rentout::checkout::edit', $value->id)."'><i class='bx bx-sm bxs-edit'></i></a> &nbsp;&nbsp;&nbsp;";
            }
            if(Permissions::Allow('Checkout.Balance Payment')) {
                $return .= "<a href='".route('Rentout::checkout::balance_payment', $value->rentout_id)."' target='_blank'><i class='bx bx-sm bx-money'></i></a> &nbsp;&nbsp;&nbsp;";
            }
            $return .= "<a href='".route('Rentout::checkout::checkout_print', $value->id)."' target='_blank'><i class='bx bx-sm bxs-printer'></i></a>";

            return $return;
        })
        ->rawColumns(['action', 'customer_id'])
        ->with('total', currency($total))
        ->with('tax', currency($tax))
        ->with('special_discount_amount', currency($special_discount_amount))
        ->with('additional_charges', currency($additional_charges))
        ->with('grand_total', currency($grand_total))
        ->with('advance_amount', currency($advance_amount))
        ->with('paid', currency($paid))
        ->with('balance', currency($balance))
        ->make(true);
    }

    public function create($id = null)
    {
        return view('admin.rentout.create', compact('id'));
    }

    public function view($id)
    {
        return view('admin.rentout.view', compact('id'));
    }

    public function pending($id)
    {
        return view('admin.rentout.pending', compact('id'));
    }

    public function single_checkout($id)
    {
        return view('admin.rentout.single_checkout', compact('id'));
    }

    public function checkin($id)
    {
        return view('admin.rentout.checkin', compact('id'));
    }

    public function balance_payment($id)
    {
        return view('admin.rentout.balance_payment', compact('id'));
    }

    public function checkout($id = null)
    {
        return view('admin.rentout.checkout', compact('id'));
    }

    public function bills()
    {
        return view('admin.rentout.bills');
    }

    public function print($id)
    {
        $Self = Rentout::find($id);

        return view('admin.rentout.print', compact('id', 'Self'));
    }

    public function bookingContractPrint($id)
    {
        $self = Rentout::find($id);
        $vat_registration_no = Settings::where('key', 'vat_registration_no_building_id_'.session('building_id'))->value('values') ?? '';

        return view('admin.rentout.booking_contract_print', compact('id', 'self', 'vat_registration_no'));
    }

    public function bookingSummaryPrint($id)
    {
        $self = Rentout::find($id);
        $vat_registration_no = Settings::where('key', 'vat_registration_no_building_id_'.session('building_id'))->value('values') ?? '';
        $journals = [];
        $journals[] = ['operation' => 'Total Rental Amount', 'voucher_number' => '---', 'date' => '', 'credit' => 0, 'debit' => $self['total']];
        $journals[] = ['operation' => 'VAT (15%)', 'voucher_number' => '---', 'date' => '', 'credit' => 0, 'debit' => percentageAmount($self['total'], 15)];
        $journals[] = ['operation' => 'Lodging tax (2.5%)', 'voucher_number' => '---', 'date' => '', 'credit' => 0, 'debit' => percentageAmount($self['total'], 2.5)];
        $journals[] = ['operation' => 'Discount', 'voucher_number' => '---', 'date' => '', 'credit' => $self['discount_amount'], 'debit' => 0];
        $journals[] = ['operation' => $self->customer->full_name, 'voucher_number' => '', 'date' => '', 'credit' => $self['advance_amount'], 'debit' => 0];

        return view('admin.rentout.booking_summary_print', compact('id', 'self', 'vat_registration_no', 'journals'));
    }

    public function checkout_print($id)
    {
        $Self = Checkout::find($id);

        return view('admin.rentout.checkout_print', compact('id', 'Self'));
    }

    public function receiptPrint($id)
    {
        $self = CheckoutPayment::find($id);
        $vat_registration_no = Settings::where('key', 'vat_registration_no_building_id_'.session('building_id'))->value('values') ?? '';

        return view('admin.rentout.receipt_print', compact('id', 'self', 'vat_registration_no'));
    }
}
