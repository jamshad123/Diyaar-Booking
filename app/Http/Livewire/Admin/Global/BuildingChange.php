<?php

namespace App\Http\Livewire\Admin\Global;

use App\Models\Building;
use App\Models\Role;
use App\Models\UserBuilding;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class BuildingChange extends Component
{
    public $building_id;

    public $buildings;

    public $user;

    public $user_id;

    public function mount()
    {
        $this->user = auth()->user();
        $this->user_id = $this->user->id;
        $buildings = new Building;
        $role_ids = $this->user->roles->pluck('role_id', 'role_id')->toArray();
        $UserBuilding = new UserBuilding;
        $UserBuilding = $UserBuilding->when($this->user_id ?? '', function ($q, $value) {
            return $q->where('user_id', $value);
        });
        $UserBuilding = $UserBuilding->pluck('building_id', 'building_id');
        $UserBuilding = $UserBuilding->toArray();
        if(! array_intersect($role_ids, [Role::SuperAdmin, Role::MD, Role::Manager])) {
            $buildings = $buildings->whereIn('id', $UserBuilding);
        }
        $buildings = $buildings->pluck('name', 'id');
        $this->buildings = $buildings->toArray();
    }

    public function updated($key, $value)
    {
        Session::put('building_id', $value);

        return redirect(url()->previous());
    }

    public function render()
    {
        return view('livewire.admin.global.building-change');
    }
}
