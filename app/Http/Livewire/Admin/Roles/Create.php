<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $closeFlag = true;

    public $permission = [];

    public $selectAll;

    public $table_id;

    public $roles;

    public $permissions;

    public $Role;

    public $permission_modules;

    public $modules;

    public $sub_modules;

    public $permission_modules_sub_modules;

    public function mount1($table_id = null)
    {
        $this->selectAll = false;
        $this->permission_modules = Permission::pluck('module', 'module')->toArray();
        $this->permission_modules_sub_modules = Permission::pluck('module', 'module')->toArray();
        $this->modules = [];
        foreach ($this->permission_modules_sub_modules as $module) {
            $this->permission_modules = Permission::where('module', $module)->select(DB::raw('SUBSTRING_INDEX(sub_module,".",1) as name'))->groupBy(DB::raw('SUBSTRING_INDEX(sub_module,".",1)'))->get();
            foreach ($this->permission_modules as $value) {
                $this->modules[$module][$value['name']] = false;
            }
        }
        foreach ($this->modules as $modules) {
            foreach ($modules as $sub_module => $value) {
                $single = Permission::where('sub_module', 'LIKE', '%'.$sub_module.'.%')->select(DB::raw('SUBSTRING_INDEX(sub_module,".",-1) as sub_module'), 'id')->orderBy('sub_module')->pluck('sub_module', 'id')->toArray();
                $this->permissions[$sub_module] = $single;
            }
        }
        $this->permission = $this->permissions;
        $this->table_id = $table_id;

        if ($table_id) {
            $this->Role = Role::select('id', 'name', 'description')->find($this->table_id);
            foreach($this->Role->permissions as $permission) {
                $this->permission[$permission->permission_id][$permission->action] = true;
            }
            $this->roles = $this->Role->toArray();
        } else {
            $this->roles = [
                'name' => '',
                'description' => '',
            ];
        }
    }

    public function mount($table_id = null)
    {
        $this->selectAll = false;
        $this->table_id = $table_id;
        $this->modules = Permission::pluck('module', 'module')->toArray();
        foreach ($this->modules as $module) {
            $permission_modules = Permission::where('module', $module)->select(DB::raw('SUBSTRING_INDEX(sub_module,".",1) as name'))->groupBy(DB::raw('SUBSTRING_INDEX(sub_module,".",1)'))->get()->toArray();
            $this->modules[$module] = [];
            foreach ($permission_modules as $value) {
                $sub_module = $value['name'];
                $single = Permission::where('sub_module', 'LIKE', '%'.$sub_module.'.%')->select(DB::raw('SUBSTRING_INDEX(sub_module,".",-1) as sub_module'), 'id')->orderBy('sub_module')->pluck('sub_module', 'id')->toArray();
                if(! $single) {
                    $single = Permission::where('sub_module', $sub_module)->pluck('sub_module', 'id')->toArray();
                }
                $this->modules[$module][$value['name']] = $single;
            }
        }
        $this->permission = Permission::pluck('id', 'id')->toArray();
        foreach($this->permission as $permission) {
            $this->permission[$permission] = false;
        }
        if ($table_id) {
            $this->Role = Role::select('id', 'name', 'description')->find($this->table_id);
            foreach($this->Role->permissions as $permission) {
                $this->permission[$permission->permission_id] = true;
            }
            $this->roles = $this->Role->toArray();
        } else {
            $this->roles = [
                'name' => '',
                'description' => '',
            ];
        }
    }

    protected $listeners = [
        'EditRole' => 'Edit',
        'CreateRole' => 'Create',
    ];

    public function Create()
    {
        $this->mount();
    }

    public function Edit($id)
    {
        $this->mount($id);
        $this->dispatchBrowserEvent('OpenRoleModal');
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $Role = new Role;
            $this->roles['permission'] = $this->permission;
            if ($this->table_id) {
                $response = $Role->selfUpdate($this->roles, $this->table_id);
            } else {
                $response = $Role->selfCreate($this->roles);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->dispatchBrowserEvent('TableDraw');
            $this->mount($this->table_id);
            DB::commit();
            if ($this->closeFlag) {
                $this->dispatchBrowserEvent('CloseRoleModal');
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    protected $rules = [
        'roles.name' => ['required'],
    ];

    protected $messages = [
        'roles.name' => 'The Role Name field is required',
    ];

    public function render()
    {
        return view('livewire.admin.roles.create');
    }
}
