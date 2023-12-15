<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Rentout;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'RentoutMultiDelete' => 'MultiDelete',
    ];

    public $status;

    public $flag;

    public $building_id;

    public $statuses;

    public $flags;

    public $types;

    public function mount($status = null, $flag = null)
    {
        $this->status = $status;
        if(! $flag) {
            $flag = Rentout::Approved;
        }
        $this->flag = $flag;
        $this->building_id = session('building_id');
        $this->statuses = Rentout::statusOptions();
        $this->flags = Rentout::flagOptions();
        $this->types = Room::typeOptions();
    }

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Rentout = new Rentout;
            foreach ($ids as  $id) {
                $response = $Rentout->selfDelete($id);
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

    public function render(Builder $htmlBuilder)
    {
        $Column = Column::make('id');
        $Column->checkboxes([
            'selectRow' => true,
            'selectAllRender' => '<input type="checkbox" class="form-check-input">',
        ]);
        $Column->searchable(true)->visible(true)->orderable(false);
        $Columns[] = $Column->title('#');
        $Columns[] = Column::make('id')->name('rentouts.id')->searchable(true)->visible(false)->className('text-center')->title('#');
        $Columns[] = Column::make('reservation_no')->searchable(true)->visible(true)->className('text-center')->title('Reservation No');
        $Columns[] = Column::make('check_in_date')->searchable(true)->visible(true)->title('check In date');
        $Columns[] = Column::make('check_out_date')->searchable(true)->visible(true)->title('check Out date');
        $Columns[] = Column::make('company_name')->searchable(true)->visible(true)->className('text-center')->title('Company Name');
        $Columns[] = Column::make('customer_id')->searchable(true)->visible(true)->title('Guest Name');
        $Columns[] = Column::make('mobile')->searchable(true)->visible(true)->title('Mobile No');
        $Columns[] = Column::make('advance_amount')->searchable(true)->visible(true)->className('text-center')->title('Total Amount');
        if(! $this->status) {
            $Columns[] = Column::make('status')->searchable(true)->visible(true)->title('status');
        } else {
            if($this->status == Rentout::Pending) {
                $Columns[] = Column::make('status')->searchable(true)->visible(true)->title('status');
            }
        }
        $Columns[] = Column::make('action')->searchable(true)->visible(true)->title('action');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Rentout::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token      = "'.csrf_token().'";
                d.building_id = "'.$this->building_id.'";
                d.agent_id    = $("#agent_id").val();
                d.room_id     = $("#room_id").val();
                d.type        = $("#type").val();
                d.status      = $("#status").val();
                d.based_on    = $("#based_on").val();
                d.start_date  = $("#start_date").val();
                d.end_date    = $("#end_date").val();
                d.customer_id = $("#customer_id").val();
                d.flag        = $("#flag").val();
            }',
        ]);
        $download[] = [
            'extend' => 'pdf',
            'text' => '<i class ="bx bxs-file-pdf me-2"></i>Pdf',
            'className' => 'dropdown-item',
        ];
        $download[] = [
            'extend' => 'excel',
            'text' => '<i class="bx bxs-file-excel me-2"></i>Excel',
            'className' => 'dropdown-item',
        ];
        $dom = '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>';
        $buttons[] = [
            'extend' => 'collection',
            'className' => 'btn btn-label-secondary dropdown-toggle mx-3',
            'text' => '<i class="bx bx-upload me-2"></i>Export',
            'buttons' => $download,
        ];
        if($this->status == 'Booked') {
            $Allow = 'Booking Delete';
        } else {
            $Allow = 'Booking Delete';
        }
        switch ($this->status) {
            case Rentout::Booked:
                $Allow = 'Booking.Delete';
                break;
            case Rentout::CheckIn:
                $Allow = 'Checkin.Delete';
                break;
            default:
                $Allow = 'Not Allowed';
                break;
        }
        if(\Permissions::Allow($Allow)) {
            $buttons[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                            selectedRows = dataTable.rows(".selected").data();
                            selectedId=[];
                            selectedRows.each((item, i) => { selectedId.push(item.id); });
                            if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                            if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                            window.livewire.emit("RentoutMultiDelete",selectedId);
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
            'buttons' => $buttons,
            'select' => [
                'style' => 'multi',
            ],
        ]);
        $htmlBuilder->parameters([
            'footerCallback' => 'function(t,o,a,l,m){
                var n=this.api(),o=dataTable.ajax.json();
                var column=5;
                column++; $(n.column(column).footer()).html("<h6><b>"+o.advance_amount+"</b></h6>");
            }',
        ]);

        return view('livewire.admin.rentout.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
