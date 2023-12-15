<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class DailyCollection extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'user_id',
        'opening_time',
        'opening_balance',
        'opening_note',
        'closing_balance',
        'closing_note',
        'closing_time',
        'flag',
    ];

    public static function openingRules($id = 0, $merge = [])
    {
        return array_merge([
            'user_id' => ['required'],
            'opening_time' => ['required'],
            'opening_balance' => ['required'],
        ], $merge);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function closingRules($id = 0, $merge = [])
    {
        return array_merge([
            'user_id' => ['required'],
            'closing_time' => ['required'],
            'closing_balance' => ['required'],
        ], $merge);
    }

    public function DayOpenCreate($data)
    {
        try {
            $data['user_id'] = auth()->user()->id;
            $duplicate = self::where('user_id', $data['user_id'])->whereBetween('opening_time', [date('Y-m-d 0:0:0'), now()])->first();
            if(! $duplicate) {
                $data['opening_time'] = now();
                $validator = Validator::make($data, $this->openingRules());
                if ($validator->fails()) {
                    foreach ($validator->errors()->getMessages() as $key => $value) {
                        throw new \Exception($value[0]);
                    }
                }
                self::create($data);
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Opened';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function DayOpenUpdate($data, $id)
    {
        try {
            $data['user_id'] = auth()->user()->id;
            $validator = Validator::make($data, $this->openingRules($id));
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::find($id);
            $Self->opening_balance = $data['opening_balance'];
            $Self->opening_note = $data['opening_note'];
            $Self->save();
            $return['result'] = true;
            $return['message'] = 'Successfully Updated Opening Balance';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function selfUpdate($data, $id)
    {
        try {
            $data['user_id'] = auth()->user()->id;
            $data['closing_time'] = now();
            $validator = Validator::make($data, $this->closingRules($id));
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::find($id);
            $Self->update($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Closed';
            Session::flush();
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }
}
