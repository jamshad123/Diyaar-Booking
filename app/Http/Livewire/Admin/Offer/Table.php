<?php

namespace App\Http\Livewire\Admin\Offer;

use App\Library\Facades\Permissions;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'MultiDelete',
        'StatusChange',
    ];

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Offer = new Offer;
            foreach ($ids as  $id) {
                $response = $Offer->selfDelete($id);
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

    public function StatusChange($ids)
    {
        try {
            DB::beginTransaction();
            $Offer = new Offer;
            foreach ($ids as  $id) {
                $response = $Offer->statusChange($id);
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
        $list = new Offer;
        $list = $list->when($request['from_date'] ?? '', function ($q, $value) {
            switch (request('based_on')) {
                case 'start_date':
                return $q->whereDate('start_date', '>=', date('Y-m-d', strtotime($value)));
                break;
                case 'end_date':
                return $q->whereDate('end_date', '>=', date('Y-m-d', strtotime($value)));
                break;
            }
        });
        $list = $list->when($request['to_date'] ?? '', function ($q, $value) {
            switch (request('based_on')) {
                case 'start_date':
                return $q->whereDate('start_date', '<=', date('Y-m-d', strtotime($value)));
                break;
                case 'end_date':
                return $q->whereDate('end_date', '<=', date('Y-m-d', strtotime($value)));
                break;
            }
        });
        $list = $list->when($request['building_id'] ?? '', function ($q, $value) {
            return $q->where('building_id', $value);
        });
        $list = $list->when($request['status'] ?? '', function ($q, $value) {
            return $q->where('status', $value);
        });

        return Datatables::of($list)
        ->editColumn('amount', function ($value) {
            return currency($value->amount);
        })
        ->editColumn('start_date', function ($value) {
            return systemDate($value->start_date);
        })
        ->editColumn('end_date', function ($value) {
            return systemDate($value->end_date);
        })
        ->addColumn('action', function ($value) {
            return '<button table_id="'.$value->id.'" class="btn btn-sm text-primary btn-icon item-edit edit"><i class="bx bxs-edit"></i></button>';
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
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
        $Columns[] = Column::make('start_date')->searchable(true)->visible(true)->title('start Date');
        $Columns[] = Column::make('end_date')->searchable(true)->visible(true)->title('end date');
        $Columns[] = Column::make('amount')->searchable(true)->className('text-end')->visible(true)->title('amount');
        $Columns[] = Column::make('status')->searchable(true)->visible(true)->title('status');
        $Columns[] = Column::make('action')->searchable(true)->visible(true)->title('Action');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('offers::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token = "'.csrf_token().'";
                d.building_id = "'.session('building_id').'";
                d.status = $("#status").val();
                d.based_on = $("#based_on").val();
                d.from_date = $("#from_date").val();
                d.to_date = $("#to_date").val();
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
        if(Permissions::Allow('Offer.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("MultiDelete",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Offer.Status Change')) {
            $actionButton[] = [
                'text' => '<span class="d-none d-lg-inline-block">Change Status</span>',
                'className' => 'btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Change Status it", "info" ); return false }
                    if(!confirm("Are You Sure To Change Status for  Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("StatusChange",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Offer.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New Offer</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    $("#OfferModal").modal("show");
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

        return view('livewire.admin.offer.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
