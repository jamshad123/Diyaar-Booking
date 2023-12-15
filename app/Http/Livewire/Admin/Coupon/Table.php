<?php

namespace App\Http\Livewire\Admin\Coupon;

use App\Library\Facades\Permissions;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'CouponMultiDelete' => 'MultiDelete',
    ];

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $model = new Coupon;
            foreach ($ids as  $id) {
                $response = $model->selfDelete($id);
                if (! $response['result']) {
                    throw new \Exception($response['message'], 1);
                }
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();
            $this->dispatchBrowserEvent('TableDraw');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function datatable(Request $request)
    {
        $datas = new Coupon;
        $datas = $datas->when($request['usage_level'] ?? '', function ($q, $value) {
            if($value == 'not_used') {
                return $q->whereNull('used_by');
            } elseif($value == 'used') {
                return $q->whereNotNull('used_by');
            }
        });
        $datas = $datas->when($request['used_by'] ?? '', function ($q, $value) {
            return $q->where('used_by', $value);
        });
        $datas = $datas->when($request['created_by'] ?? '', function ($q, $value) {
            return $q->where('created_by', $value);
        });
        $total = clone $datas;
        $total = $total->sum('amount');

        return Datatables::of($datas)
        ->editColumn('amount', function ($value) {
            return currency($value->amount);
        })
        ->editColumn('expiry_at', function ($value) {
            return systemDate($value->expiry_at);
        })
        ->editColumn('created_by', function ($value) {
            return $value->createdBy->name;
        })
        ->editColumn('used_by', function ($value) {
            return $value->used_by ? $value->usedBy->name : '';
        })
        ->editColumn('rentout_id', function ($value) {
            if($value->rentout_id) {
                return "<a href='".route('Rentout::edit', $value->rentout_id)."'>".$value->rentout->registration_no.'</a>';
            }
        })
        ->addIndexColumn()
        ->rawColumns(['action', 'rentout_id'])
        ->with('total', currency($total))
        ->make(true);
    }

    public function render(Builder $htmlBuilder)
    {
        $Column = Column::make('id');
        $Column->checkboxes([
            'selectRow' => true,
            'selectAllRender' => '<input type="checkbox" class="form-check-input">',
        ]);
        $Column->searchable(true)->visible(true)->orderable(false);
        $Columns[] = $Column->title('#');
        $Columns[] = Column::make('code')->searchable(true)->visible(true)->title('code');
        $Columns[] = Column::make('amount')->searchable(true)->visible(true)->className('text-end')->title('amount');
        $Columns[] = Column::make('expiry_at')->searchable(true)->visible(true)->title('expiry at');
        $Columns[] = Column::make('created_by')->searchable(true)->visible(true)->title('created by');
        $Columns[] = Column::make('used_by')->searchable(true)->visible(true)->title('used by');
        $Columns[] = Column::make('rentout_id')->searchable(true)->visible(true)->title('rentout');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('coupons::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token = "'.csrf_token().'";
                d.usage_level = $("#usage_level").val();
                d.created_by = $("#created_by").val();
                d.used_by = $("#used_by").val();
            }',
        ]);
        $buttons[] = [
            'extend' => 'pdf',
            'text' => '<i class ="bx bxs-file-pdf me-2"></i>Pdf',
            'className' => 'dropdown-item',
        ];
        $buttons[] = [
            'extend' => 'excel',
            'text' => '<i class="bx bxs-file-excel me-2"></i>Excel',
            'className' => 'dropdown-item',
        ];
        $dom = '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>';

        $actionButton[] = [
            'extend' => 'collection',
            'className' => 'btn btn-label-secondary dropdown-toggle mx-3',
            'text' => '<i class="bx bx-upload me-2"></i>Export',
            'buttons' => $buttons,
        ];
        if(Permissions::Allow('Coupon.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("CouponMultiDelete",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Coupon.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New Coupon</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    $("#CouponModal").modal("show");
                }',
            ];
        }
        $htmlBuilder->parameters([
            'lengthMenu' => [[10, 50, 100, '-1'], [10, 50, 100, 'All']],
            'order' => [[1, 'desc']],
            'dom' => $dom,
            'language' => [
                'sLengthMenu' => '_MENU_',
                'search' => '',
                'searchPlaceholder' => 'Search..',
            ],
            'buttons' => $actionButton,
            'select' => [
                'style' => 'multi',
            ],
        ]);
        $htmlBuilder->parameters([
            'footerCallback' => 'function(t,o,a,l,m){
                var n=this.api(),o=dataTable.ajax.json();
                var column=0;
                column++; $(n.column(column).footer()).html("<h6><b>Total</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.total+"</b></h6>");
            }',
        ]);
        $users = User::pluck('name', 'id')->toArray();

        return view('livewire.admin.coupon.table')
        ->with('users', $users)
        ->with('htmlBuilder', $htmlBuilder);
    }
}
