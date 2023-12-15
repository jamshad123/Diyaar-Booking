<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Offer extends Model
{
    use HasFactory;

    const Active = 'Active';

    const Disabled = 'Disabled';

    protected $fillable = [
        'building_id',
        'start_date',
        'end_date',
        'amount',
        'status',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'building_id' => ['required'],
            'amount' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required'],
        ], $merge);
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function scopeActive($query)
    {
        $query->where('status', '=', self::Active);
    }

    public function scopeBuilding($query)
    {
        $query->where('building_id', '=', session('building_id'));
    }

    public function scopeDisabled($query)
    {
        $query->where('status', '=', self::Disabled);
    }

    public function selfCreate($data)
    {
        try {
            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            self::create($data);
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
            $validator = Validator::make($data, $this->UsedRule($id));
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

    public function statusChange($id)
    {
        try {
            $Self = self::find($id);
            $Self->status = ($Self->status == 'Active') ? self::Disabled : self::Active;
            $Self->save();
            $return['result'] = true;
            $return['message'] = 'Successfully Changed Status';
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
                throw new \Exception('Cant Delete This Offer'.$id, 1);
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
