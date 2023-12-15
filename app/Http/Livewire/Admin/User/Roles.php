<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Roles extends Component
{
    public $user_id;

    public $User;

    public $Roles;

    public $user_roles;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->User = User::find($user_id);
        $this->Roles = Role::pluck('name', 'id');
        $this->user_roles = $this->User->roles()->pluck('role_id')->toArray();
    }

    public function UserRole($role_id)
    {
        try {
            DB::beginTransaction();
            $UserHasRole = new UserHasRole;
            $role['user_id'] = $this->user_id;
            $role['role_id'] = $role_id;
            $response = $UserHasRole->roleAssign($role);
            if(! $response['result']) throw new \Exception($response['message'], 1);
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $UserHasRole = new UserHasRole;
            UserHasRole::where('user_id', $this->user_id)->delete();
            if(! $this->user_roles) {
                throw new \Exception('Please Add Any Roles', 1);
            }
            foreach ($this->user_roles as  $role_id) {
                $role['user_id'] = $this->user_id;
                $role['role_id'] = $role_id;
                $response = $UserHasRole->roleAssign($role);
                if(! $response['result']) throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.roles');
    }
}
