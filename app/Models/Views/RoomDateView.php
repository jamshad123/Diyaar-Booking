<?php

namespace App\Models\Views;

use App\Models\Rentout;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomDateView extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function scopeBooked($query)
    {
        return $query->where('room_date_views.status', Rentout::Booked);
    }

    public function scopeCheckIn($query)
    {
        return $query->where('room_date_views.status', Rentout::CheckIn);
    }
}
