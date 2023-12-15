<?php

namespace App\Http\Livewire\Admin\Room;

use App\Library\Facades\Permissions;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'RoomMultiDelete' => 'MultiDelete',
    ];

    public $building_id;

    public $Building;

    public $Rooms;

    public $floors;

    public $types;

    public $hygiene_statuses;

    public $statuses;

    public $TypeGroupCount;

    public $StatusGroupCount;

    public $HygieneStatusGroupCount;

    public function mount()
    {
        $this->building_id = session('building_id');
        $this->Building = Building::pluck('name', 'id')->toArray();
        $this->Rooms = Room::buildingId($this->building_id)->limit(20)->get();
        $this->floors = Room::buildingId($this->building_id)->pluck('floor', 'floor')->toArray();
        $this->types = Room::typeOptions();
        $this->hygiene_statuses = Room::hygieneStatusOptions();
        $this->statuses = Room::statusOptions();
        $this->TypeGroupCount = Room::buildingId($this->building_id)->groupCount('type')->get()->toArray();
        $this->StatusGroupCount = Room::buildingId($this->building_id)->groupCount('status')->get()->toArray();
        $this->HygieneStatusGroupCount = Room::buildingId($this->building_id)->groupCount('hygiene_status')->get()->toArray();
    }

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Room = new Room;
            foreach ($ids as  $id) {
                $response = $Room->selfDelete($id);
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
        $Column->searchable(true)->visible(true);
        $Columns[] = $Column->title('#');
        if ($this->building_id) {
            $Columns[] = Column::make('Building')->searchable(true)->visible(false)->title('Building');
        } else {
            $Columns[] = Column::make('Building')->searchable(true)->visible(true)->title('Building');
        }
        $Columns[] = Column::make('id')->searchable(true)->visible(true)->className('text-end')->title('#');
        $Columns[] = Column::make('room_no')->searchable(true)->visible(true)->className('text-end')->title('room no');
        $Columns[] = Column::make('floor')->searchable(true)->visible(true)->title('floor');
        $Columns[] = Column::make('type')->searchable(true)->visible(true)->title('type');
        $Columns[] = Column::make('amount')->searchable(true)->visible(true)->className('text-end')->title('amount');
        $Columns[] = Column::make('hygiene_status')->searchable(true)->visible(true)->title('hygiene status');
        $Columns[] = Column::make('capacity')->searchable(true)->visible(true)->className('text-end')->title('capacity');
        $Columns[] = Column::make('extra_capacity')->searchable(true)->visible(true)->className('text-end')->title('Extra Capacity');
        $Columns[] = Column::make('no_of_beds')->searchable(true)->visible(true)->className('text-end')->title('no of beds');
        $Columns[] = Column::make('status')->searchable(true)->visible(true)->title('status');
        if(Permissions::Allow('Room.Edit')) {
            $Columns[] = Column::make('action')->searchable(false)->orderable(true)->title('Action');
        }
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Building::Room::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token         = "'.csrf_token().'";
                d.building_id    = "'.$this->building_id.'";
                d.floor          = $("#floor").val();
                d.type           = $("#type").val();
                d.hygiene_status = $("#hygiene_status").val();
                d.status         = $("#status").val();
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
            'className' => 'btn btn-label-secondary dropdown-toggle',
            'text' => '<i class="bx bx-upload me-2"></i>',
            'buttons' => $buttons,
        ];
        if(Permissions::Allow('Room.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0"></i>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Room To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rooms!")){ return false; }
                    window.livewire.emit("RoomMultiDelete",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Room.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0"></i>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    window.livewire.emit("CreateRoom",'.$this->building_id.');
                    $("#RoomModal").modal("show");
                }',
            ];
        }
        if(Permissions::Allow('Room.Bed No')) {
            $actionButton[] = [
                'text' => '<span class ="d-none d-lg-inline-block">Change Bed No</span>',
                'className' => 'add-new btn btn-info',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Room To Change the Bed No", "info" ); return false }
                    if(!confirm("Are You Sure To Change Room\'s Bed No for Selected("+selectedId.length+") Rooms!")){ return false; }
                    window.livewire.emit("OpenRoomBedNoComponent",selectedId);
                }',
            ];
        }

        if(Permissions::Allow('Room.Room Price')) {
            $actionButton[] = [
                'text' => '<span class ="d-none d-lg-inline-block">Change Room Price</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Room To Change the Room Price", "info" ); return false }
                    if(!confirm("Are You Sure To Change Room Price for Selected("+selectedId.length+") Rooms!")){ return false; }
                    window.livewire.emit("OpenRoomPriceComponent",selectedId);
                }',
            ];
        }

        $actionButton[] = [
            'className' => 'btn btn-label-secondary',
            'text' => '<i class="bx bx-filter me-2"></i>',
            'action' => 'function ( e, dt, node, config ) {
                $("#tableFilter").toggle();
            }',
        ];
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
            'initComplete' => 'function () {
                $(".dataTables_filter input").css({"width": "150px"});
            }',
        ]);

        return view('livewire.admin.room.table')
            ->with('htmlBuilder', $htmlBuilder);
    }
}
