<?php

namespace App\Models\Views;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferView extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        $query->where('status', '=', Offer::Active);
    }

    public function scopeBuilding($query)
    {
        $query->where('building_id', '=', session('building_id'));
    }
}
