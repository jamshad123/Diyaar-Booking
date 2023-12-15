<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'created_by',
        'used_by',
        'rentout_id',
        'expiry_at',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function rentout()
    {
        return $this->belongsTo(Rentout::class, 'rentout_id');
    }

    public function scopeNotUsed($query)
    {
        $query->whereNull('rentout_id');
    }

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'code' => ['required'],
            'amount' => ['required'],
            'created_by' => ['required'],
        ], $merge);
    }

    public static function UsedRule($id = 0, $merge = [])
    {
        return array_merge([
            'used_by' => ['required'],
            'rentout_id' => ['required'],
        ], $merge);
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
            $Self = self::create($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Created';
            $return['id'] = $Self->id;
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

    public function selfDelete($id)
    {
        try {
            $Self = self::find($id);
            if (! $Self->delete()) {
                throw new \Exception('Cant Delete This Coupon'.$id, 1);
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
