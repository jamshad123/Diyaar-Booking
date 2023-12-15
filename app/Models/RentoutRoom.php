<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class RentoutRoom extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'rentout_id',
        'building_id',
        'room_id',
        'customer_id',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'amount',
        'no_of_days',
        'total',
        'no_of_adult',
        'no_of_children',
        'status',
    ];

     protected $messages = [
         'rentout_id.required' => 'The rentout id field is required',
         'customer_id.required' => 'The customer id field is required',
         'building_id.required' => 'The building id field is required',
         'room_id.required' => 'The room id field is required',
         'check_in_date.required' => 'The check in date field is required',
         'check_out_date.required' => 'The check out date field is required',
         'check_in_time.required' => 'The check in time field is required',
         'check_out_time.required' => 'The check out time field is required',
         'amount.required' => 'The amount field is required',
         'no_of_days.required' => 'The no_of_days field is required',
         'total.required' => 'The total field is required',
     ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'rentout_id' => ['required'],
            'customer_id' => ['required'],
            'building_id' => ['required'],
            'room_id' => ['required'],
            'check_in_date' => ['required'],
            'check_out_date' => ['required'],
            'check_in_time' => ['required'],
            'check_out_time' => ['required'],
            'amount' => ['required'],
            'no_of_days' => ['required'],
            'total' => ['required'],
        ], $merge);
    }

    public static function boot()
    {
        parent::boot();
        self::saved(function ($model) {
            switch ($model->status) {
                case Rentout::Pending:
                break;
                case Rentout::Booked:
                break;
                case Rentout::CheckIn:
                break;
                case Rentout::CheckOut:
                $model->Room->hygiene_status = Room::Dirty;
                $model->Room->save();
                break;
                case Rentout::Cancelled:
                break;
            }
        });
    }

    public function getcheckOutDatetimeAttribute()
    {
        return $this->check_out_date.$this->check_out_time;
    }

    public function getcheckInDatetimeAttribute()
    {
        return $this->check_in_date.$this->check_in_time;
    }

    public function scopeCheckIn($query)
    {
        return $query->where('rentout_rooms.status', Rentout::CheckIn);
    }

    public function scopeBooked($query)
    {
        return $query->where('rentout_rooms.status', Rentout::Booked);
    }

    public function scopeCurrentBuilding($query)
    {
        return $query->where('rentout_rooms.building_id', session('building_id'));
    }

    public function rentout()
    {
        return $this->belongsTo(Rentout::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function roomDates()
    {
        return $this->hasMany(\App\Models\Views\RoomDateView::class, 'id', 'id');
    }

    public function selfCreate($data)
    {
        try {
            $validator = Validator::make($data, $this->rules(), $this->messages);
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::create($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Created';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function selfUpdate($data, $id)
    {
        try {
            $validator = Validator::make($data, $this->rules($id));
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::find($id);
            $Self->update($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Updated';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function selfCheckout($id)
    {
        try {
            $data['status'] = Rentout::CheckOut;
            $Self = self::find($id);
            $Self->update($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Updated';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function selfDelete($id)
    {
        try {
            $Self = self::find($id);
            if (! $Self->delete()) {
                throw new \Exception('Cant Delete This Rentout'.$id, 1);
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Deleted';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }
}
