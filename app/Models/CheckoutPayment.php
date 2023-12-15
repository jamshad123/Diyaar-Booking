<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class CheckoutPayment extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'checkout_id',
        'payment_mode',
        'amount',
        'created_by',
        'updated_by',
    ];

    public const Direct = 'Direct Payment';

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'checkout_id' => ['required'],
            'payment_mode' => ['required'],
            'amount' => ['required'],
        ], $merge);
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function selfCreate($data)
    {
        try {
            $data['created_by'] = auth()->user()->id;
            $data['updated_by'] = auth()->user()->id;
            $validator = Validator::make($data, $this->rules());
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
            $data['updated_by'] = auth()->user()->id;
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

    public function selfDelete($id)
    {
        try {
            $Self = self::find($id);
            if (! $Self->delete()) {
                throw new \Exception('Cant Delete This Payment'.$id, 1);
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
