<?php

namespace App\Library\Helpers;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

class Permissions
{
    public function Allow($sub_module)
    {
        $roles = Auth::user()->roles->pluck('role_id')->toArray();
        if (in_array(Role::SuperAdmin, $roles)) {
            return true;
        } else {
            $permission = RolePermission::whereIn('role_id', $roles)->whereHas('permission', function ($q) use ($sub_module) {
                $q->whereIn('permissions.sub_module', explode('|', $sub_module));
            });
            $permission = $permission->count();
            if ($permission) {
                return true;
            }

            return false;
        }
    }

    public function AllowModule($module)
    {
        $roles = Auth::user()->roles->pluck('role_id')->toArray();
        if (in_array(Role::SuperAdmin, $roles)) {
            return true;
        } else {
            $permission = RolePermission::whereIn('role_id', $roles)->whereHas('permission', function ($q) use ($module) {
                $q->whereIn('permissions.module', explode('|', $module));
            });
            $permission = $permission->count();
            if ($permission) {
                return true;
            }

            return false;
        }
    }
}
