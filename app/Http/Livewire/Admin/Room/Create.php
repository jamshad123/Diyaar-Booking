<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    protected $listeners = [
        'EditRoom' => 'Edit',
        'CreateRoom' => 'Create',
    ];

    protected $rules = [
        'rooms.building_id' => ['required'],
        'rooms.room_no' => ['required'],
        'rooms.floor' => ['required'],
        'rooms.type' => ['required'],
        'rooms.hygiene_status' => ['required'],
    ];

    protected $messages = [
        'rooms.building_id' => 'The building field is required',
        'rooms.room_no' => 'The rooms no field is required',
        'rooms.floor' => 'The floor field is required',
        'rooms.type' => 'The type field is required',
        'rooms.hygiene_status' => 'The hygiene status field is required',
    ];

    public $closeFlag = true;

    public function mount()
    {
        $this->building_id = session('building_id');
        $this->Building = Building::pluck('name', 'id')->toArray();
        $this->types = Room::typeOptions();
        $this->hygiene_statuses = Room::hygieneStatusOptions();
        $this->statuses = Room::statusOptions();
        $this->rooms = [
            'building_id' => $this->building_id,
            'room_no' => '',
            'floor' => '',
            'type' => '',
            'amount' => '',
            'hygiene_status' => Room::Clean,
            'status' => Room::Vacant,
            'description' => '',
            'reserve_condition' => '',
        ];
    }

    public function Create()
    {
        $this->mount();
    }

    public function Edit($id)
    {
        $this->Room = Room::find($id);
        $this->mount($this->Room->building_id);
        $this->rooms = $this->Room->toArray();
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $Room = new Room;
            if (! isset($this->rooms['id'])) {
                $response = $Room->selfCreate($this->rooms);
            } else {
                $response = $Room->selfUpdate($this->rooms, $this->rooms['id']);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->dispatchBrowserEvent('TableDraw');
            $this->mount($this->building_id);
            if (isset($this->Room['id'])) {
                $this->rooms = $this->Room->toArray();
            }
            if ($this->closeFlag) {
                $this->dispatchBrowserEvent('CloseRoomModal');
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.room.create');
    }
}
