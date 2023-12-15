<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        $data = [];
        $data[] = ['module' => 'User', 'sub_module' => 'User.Create'];
        $data[] = ['module' => 'User', 'sub_module' => 'User.Read'];
        $data[] = ['module' => 'User', 'sub_module' => 'User.Edit'];

        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Create'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Read'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Edit'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Delete'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Bed No'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Room Price'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room Status.Table View'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room Status.Grid View'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room Plan'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Hygiene Status'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Inactive'];
        $data[] = ['module' => 'Room', 'sub_module' => 'Room.Maintenance'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Agent.Create'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Agent.Read'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Agent.Edit'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Agent.Delete'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Building.Create'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Building.Read'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Building.Edit'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Building.Delete'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Customer.Create'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Customer.Read'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Customer.Edit'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Customer.Delete'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Role.Create'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Role.Read'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Role.Edit'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Role.Delete'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Coupon.Create'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Coupon.Read'];
        $data[] = ['module' => 'Settings', 'sub_module' => 'Coupon.Delete'];

        $data[] = ['module' => 'Settings', 'sub_module' => 'Settings'];

        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Create'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.View'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Edit'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Delete'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Agent'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Discount'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Security deposit'];
        // $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.Payment'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'BookedPending.list'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'BookedPending.Approve'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Booking.List'];

        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkin.Create'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkin.Edit'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkin.Delete'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkin.List'];

        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkout.Create'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkout.Edit'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkout.Discount'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkout.Balance Payment'];
        $data[] = ['module' => 'Reservation', 'sub_module' => 'Checkout.Payment Delete'];

        $data[] = ['module' => 'Reservation', 'sub_module' => 'DayCollection'];

        $data[] = ['module' => 'Report', 'sub_module' => 'Checkout Report'];
        $data[] = ['module' => 'Report', 'sub_module' => 'Reservation Report'];
        $data[] = ['module' => 'Report', 'sub_module' => 'Payment Report'];

        $data[] = ['module' => 'Collection', 'sub_module' => 'Collection'];

        $data[] = ['module' => 'Offers', 'sub_module' => 'Offer.Create'];
        $data[] = ['module' => 'Offers', 'sub_module' => 'Offer.Read'];
        $data[] = ['module' => 'Offers', 'sub_module' => 'Offer.Edit'];
        $data[] = ['module' => 'Offers', 'sub_module' => 'Offer.Delete'];

        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Today Booking'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Today Checkin'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Total Customer'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Total Amount'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Available Rooms'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Dirty Rooms'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Buildings'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Today Booking List'];
        $data[] = ['module' => 'Dashboard', 'sub_module' => 'Dashboard.Next Day Booking List'];
        DB::table('permissions')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
