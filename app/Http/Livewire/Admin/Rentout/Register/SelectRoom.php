<?php

namespace App\Http\Livewire\Admin\Rentout\Register;

use App\Actions\Room\RoomPriceCheckAction;
use App\Models\Rentout;
use App\Models\RentoutRoom;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class SelectRoom extends Component
{
    public $closeFlag = true;

    public $type = '';

    public $floor = '';

    public $no_of_beds = '';

    public $no_of_rooms = '';

    public $BasedOn;

    public $based_on;

    public $selectedRooms;

    public $building_id;

    public $types;

    public $rentouts;

    public $floors;

    public $room_ids;

    public $available_no_of_rooms;

    public $available_no_of_beds;

    public $selected_no_of_rooms;

    public $selected_no_of_beds;

    protected $listeners = [
        'SelectRoom',
        'AddRooms',
        'RemoveRooms',
    ];

    public function SelectRoom($rentouts = [], $selectedRooms = [])
    {
        Session::put('rentouts', $rentouts);
        $this->mount($rentouts, $selectedRooms);
        if ($selectedRooms) {
            Session::put('SelectedRoomIds', array_column($selectedRooms, 'room_id'));
        } else {
            Session::put('SelectedRoomIds', []);
        }
        $this->dispatchBrowserEvent('SelectModelTableDraw');
        $this->dispatchBrowserEvent('OpenSelectRoomModal');
    }

    public function mount($rentouts = [], $selectedRooms = [])
    {
        $this->BasedOn = [
            'no_of_rooms' => 'No Of Rooms',
            'no_of_beds' => 'No Of Beds',
        ];
        $this->based_on = 'no_of_rooms';
        $this->rentouts = $rentouts;
        $this->selectedRooms = $selectedRooms;
        $this->building_id = session('building_id');
        $this->types = Room::typeOptions();
        $this->floors = Room::buildingId($this->building_id)->pluck('floor', 'floor')->toArray();
        $this->room_ids = [];
        $this->LoadSummaryTableData();
    }

    public function LoadSummaryTableData()
    {
        $AvailableRooms = $this->GetAvailableRooms();
        $this->available_no_of_rooms = $AvailableRooms->count();
        $this->available_no_of_beds = $AvailableRooms->sum('no_of_beds');
        $SelectedRoomIds = Session::get('SelectedRoomIds') ?? [];
        $SelectedRooms = Room::whereIn('id', $SelectedRoomIds);
        $this->selected_no_of_rooms = $SelectedRooms->count();
        $this->selected_no_of_beds = $SelectedRooms->sum('no_of_beds');
    }

    public function AddRooms($roomIds)
    {
        $check_in_date = date('Y-m-d', strtotime($this->rentouts['check_in_date']));
        $check_out_date = date('Y-m-d', strtotime($this->rentouts['check_out_date']));
        $action = new RoomPriceCheckAction;
        $this->selectedRooms = $action->execute($this->selectedRooms, $roomIds, $check_in_date, $check_out_date);
        Session::put('SelectedRoomIds', array_column($this->selectedRooms, 'room_id'));
        $this->LoadSummaryTableData();
        $this->emit('SendSelectedRooms', $this->selectedRooms);
        $this->dispatchBrowserEvent('SelectModelTableDraw');
        $this->dispatchBrowserEvent('success', ['message' => 'Room added successfully']);
        $this->dispatchBrowserEvent('CloseSelectRoomModal');
    }

    public function RemoveRooms($roomIds)
    {
        try {
            DB::beginTransaction();
            foreach ($roomIds as $room_id) {
                if (isset($this->selectedRooms[$room_id]['id'])) {
                    $RentoutRoom = new RentoutRoom;
                    $response = $RentoutRoom->selfDelete($this->selectedRooms[$room_id]['id']);
                    if ($response['result'] != 'success') throw new \Exception($response['result'], 1);
                }
                if (! isset($this->selectedRooms[$room_id])) throw new \Exception('Room Not Found', 1);
                unset($this->selectedRooms[$room_id]);
            }
            Session::put('SelectedRoomIds', array_column($this->selectedRooms, 'room_id'));
            $this->emit('SendSelectedRooms', $this->selectedRooms);
            $this->LoadSummaryTableData();
            DB::commit();
            $this->dispatchBrowserEvent('SelectModelTableDraw');
            $this->dispatchBrowserEvent('warning', ['message' => 'Successfully deleted the room']);
        } catch (Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function save()
    {

    }

    public function GetAvailableRooms($data = [])
    {
        $datas = new Room;
        $rentouts = Session::get('rentouts');
        if ($rentouts) {
            $check_in_date = date('Y-m-d', strtotime($rentouts['check_in_date']));
            $check_out_date = date('Y-m-d', strtotime($rentouts['check_out_date']));
            $RoomDateView = RoomDateView::whereBetween('date', [$check_in_date, $check_out_date]);
            $RoomDateView = $RoomDateView->whereIn('status', [Rentout::Booked, Rentout::CheckIn, Rentout::CheckOut, Rentout::Pending]);
            $BookedRoomIds = $RoomDateView->pluck('room_id', 'room_id')->toArray();
            $datas = new Room;
            $datas = $datas->active();
            $datas = $datas->buildingId(session('building_id'));
            $datas = $datas->when($BookedRoomIds, function ($q, $value) {
                return $q->whereNotIn('id', $value);
            });
            $datas = $datas->when($data['type'] ?? '', function ($q, $value) {
                return $q->where('type', $value);
            });
            $datas = $datas->when($data['floor'] ?? '', function ($q, $value) {
                return $q->where('floor', $value);
            });
            $SelectedRoomIds = Session::get('SelectedRoomIds') ?? [];
            $datas = $datas->when($SelectedRoomIds ?? [], function ($q, $value) {
                return $q->whereNotIn('id', $value);
            });
        } else {
            $datas = $datas->where('id', 'asd');
        }

        return $datas;
    }

    public function AvailableRoomDataTable(Request $request)
    {
        $data = $request->all();
        $datas = $this->GetAvailableRooms($data);

        return Datatables::of($datas)
            ->addIndexColumn()
            ->make(true);
    }

    public function SelectedRoomDataTable(Request $request)
    {
        $data = $request->all();
        $datas = new Room;
        $datas = $datas->buildingId(session('building_id'));
        $datas = $datas->when($data['type'], function ($q, $value) {
            return $q->where('type', $value);
        });
        $datas = $datas->when($data['floor'], function ($q, $value) {
            return $q->where('floor', $value);
        });
        $SelectedRoomIds = Session::get('SelectedRoomIds') ?? [];
        $datas = $datas->whereIn('id', $SelectedRoomIds);

        return Datatables::of($datas)
            ->addIndexColumn()
            ->make(true);
    }

    public function Check()
    {
        $data['type'] = $this->type;
        $data['floor'] = $this->floor;
        $datas = $this->GetAvailableRooms($data);
        $datas = $datas->orderBy('room_no');
        switch ($this->based_on) {
            case 'no_of_rooms':
                if($this->no_of_rooms > 0) {
                    $datas = $datas->limit($this->no_of_rooms);
                    $room_ids = $datas->pluck('id', 'id')->toArray();
                    if($room_ids) {
                        $this->AddRooms($room_ids);
                    } else {
                        $this->dispatchBrowserEvent('error', ['message' => 'No Rooms Available']);
                    }
                }
                break;
            case 'no_of_beds':
                if($this->no_of_beds > 0) {
                    $datas = $datas->pluck('no_of_beds', 'id')->toArray();
                    $room_ids = [];
                    $beds = $this->no_of_beds;
                    foreach ($datas as $room_id => $no_of_beds) {
                        if ($beds > 0) {
                            $room_ids[$room_id] = $room_id;
                            $beds -= $no_of_beds;
                        } else {
                            break;
                        }
                    }
                    if($room_ids) {
                        $this->AddRooms($room_ids);
                    } else {
                        $this->dispatchBrowserEvent('error', ['message' => 'No Rooms Available']);
                    }
                }
                break;
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
        $Columns[] = Column::make('room_no')->searchable(true)->className('text-end')->visible(true)->title('Room No');
        $Columns[] = Column::make('type')->searchable(true)->visible(true)->title('Type');
        $Columns[] = Column::make('floor')->searchable(true)->visible(true)->title('Floor');
        $Columns[] = Column::make('no_of_beds')->searchable(true)->className('text-end')->visible(true)->title('No Of beds');
        $Columns[] = Column::make('hygiene_status')->searchable(true)->visible(true)->title('Hygiene Status');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Rentout::availableroom::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token        = "'.csrf_token().'";
                d.floor         = $("#select_modal_floor").val();
                d.type          = $("#select_modal_type").val();
                d.selectedRooms = $("#selectedRooms").val();
            }',
        ]);
        $dom = '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>';
        $htmlBuilder->parameters([
            'lengthMenu' => [[10, 50, 100, '-1'], [10, 50, 100, 'All']],
            'order' => [[1, 'desc']],
            'bInfo' => false,
            'paging' => false,
            'scrollY' => '40vh',
            'scrollCollapse' => true,
            'dom' => $dom,
            'language' => [
                'sLengthMenu' => '_MENU_',
                'search' => '',
                'searchPlaceholder' => 'Search..',
            ],
            'buttons' => [
                [
                    'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add To Selected Rooms</span>',
                    'className' => 'add-new btn btn-primary',
                    'action' => 'function ( e, dt, node, config ) {
                        selectedRows = AvailableRoomDataTable.rows(".selected").data();
                        selectedId=[];
                        selectedRows.each((item, i) => { selectedId.push(item.id); });
                        if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Room To Add it", "info" ); return false }
                        if(!confirm("Are You Sure To Add Selected("+selectedId.length+") Room(s)!")){ return false; }
                        window.livewire.emit("AddRooms",selectedId);
                    }',
                ],
            ],
            'select' => [
                'style' => 'multi',
            ],
        ]);

        return view('livewire.admin.rentout.register.select-room')
            ->with('htmlBuilder', $htmlBuilder);
    }
}
