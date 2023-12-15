<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        DB::table('role_permissions')->truncate();
        $data = [];
        $data = array_merge($data, $this->SuperAdmin());
        $data = array_merge($data, $this->MD());
        $data = array_merge($data, $this->Manager());
        $data = array_merge($data, $this->Receptionist());
        $data = array_merge($data, $this->Supervisor());
        $data = array_merge($data, $this->Collection());
        DB::table('role_permissions')->insert($data);
    }

    public function SuperAdmin()
    {
        $permissions = DB::table('permissions')->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::SuperAdmin];
        }

        return $data;
    }

    public function MD()
    {
        $sub_modules = [
            'User.Create',
            'User.Read',
            'User.Edit',
            'Room.Read',
            'Room-Room Status',
            'Room-Room Plan',
            'Room.Hygiene Status',
            'Agent.Read',
            'Agent.Create',
            'Agent.Edit',
            'Agent.Delete',
            'Building.Create',
            'Building.Read',
            'Building.Edit',
            'Building.Delete',
            'Customer.Create',
            'Customer.Read',
            'Customer.Edit',
            'Customer.Delete',
            'Role.Create',
            'Role.Read',
            'Role.Edit',
            'Role.Delete',
            'Settings',
            'Booking',
            'Booking List',
            'Booking Edit',
            'Checkin',
            'Checkin Edit',
            'Checkout',
            'Booking Approve',
            'Booking Delete',
            'Checkin Delete',
            'Checkout Report',
            'Reservation Report',
            'Booking Report',
            'Payment Report',
            'Collection',
        ];
        $permissions = DB::table('permissions')->whereIn('sub_module', $sub_modules)->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::MD];
        }

        return $data;
    }

    public function Manager()
    {
        $sub_modules = [
            'User.Create',
            'User.Read',
            'User.Edit',
            'Room-Room Status',
            'Room-Room Plan',
            'Room.Hygiene Status',
            'Agent.Read',
            'Agent.Create',
            'Agent.Edit',
            'Agent.Delete',
            'Building.Create',
            'Building.Read',
            'Building.Edit',
            'Building.Delete',
            'Customer.Create',
            'Customer.Read',
            'Customer.Edit',
            'Customer.Delete',
            'Settings',
            'Booking',
            'Booking List',
            'Booking Edit',
            'Checkin',
            'Checkin Edit',
            'Checkout',
            'Booking Approve',
            'Booking Delete',
            'Checkin Delete',
            'Checkout Report',
            'Reservation Report',
            'Booking Report',
            'Payment Report',
            'Collection',
        ];
        $permissions = DB::table('permissions')->whereIn('sub_module', $sub_modules)->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::Manager];
        }

        return $data;
    }

    public function Receptionist()
    {
        $sub_modules = [
            'Room-Room Status',
            'Room-Room Plan',
            'Booking List',
            'Checkin',
            'Checkout',
            'Checkout Report',
        ];
        $permissions = DB::table('permissions')->whereIn('sub_module', $sub_modules)->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::Receptionist];
        }

        return $data;
    }

    public function Supervisor()
    {
        $sub_modules = [
            'Room-Room Status',
            'Room-Room Plan',
            'Room.Hygiene Status',
            'Checkin',
            'Checkout',
            'Checkout Report',
            'Reservation Report',
            'Booking Report',
            'Payment Report',
        ];
        $permissions = DB::table('permissions')->whereIn('sub_module', $sub_modules)->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::Supervisor];
        }

        return $data;
    }

    public function Collection()
    {
        $sub_modules = [
            'Collection',
            'Room-Room Status',
            'Room-Room Plan',
            'Room.Hygiene Status',
            'Checkin',
            'Checkout',
            'Checkout Report',
            'Reservation Report',
            'Booking Report',
            'Payment Report',
        ];
        $permissions = DB::table('permissions')->whereIn('sub_module', $sub_modules)->get();
        $data = [];
        foreach ($permissions as $value) {
            $data[] = ['permission_id' => $value->id, 'role_id' => Role::Collection];
        }

        return $data;
    }
}
