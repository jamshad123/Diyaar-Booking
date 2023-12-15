<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class Checkout extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'building_id',
        'rentout_id',
        'customer_id',
        'total',
        'tax',
        'security_deposit_payment_mode',
        'security_amount',
        'security_reason',
        'booking_discount_amount',
        'special_discount_amount',
        'special_discount_reason',
        'additional_charges',
        'additional_charge_comments',
        'grand_total',
        'advance_amount',
        'paid',
        'balance',
        'created_by',
        'updated_by',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'rentout_id' => ['required'],
            'customer_id' => ['required'],
            'total' => ['required'],
            'grand_total' => ['required'],
        ], $merge);
    }

    public static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            $model->paid = $model->payments->sum('amount');
            $model->balance = $model->grand_total - $model->advance_amount - $model->paid;
        });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function rentout()
    {
        return $this->belongsTo(Rentout::class);
    }

    public function rentouts()
    {
        return $this->hasMany(Rentout::class, 'checkout_id');
    }

    public function payments()
    {
        return $this->hasMany(CheckoutPayment::class, 'checkout_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function checkoutPayments()
    {
        return $this->hasMany(CheckoutPayment::class, 'checkout_id');
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
            if ($data['rooms']) {
                $RentoutRoom = new RentoutRoom;
                foreach ($data['rooms'] as $key => $value) {
                    $response = $RentoutRoom->selfCheckout($value['id']);
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            if ($data['rentout_ids']) {
                $RentoutData = [
                    'checkout_id' => $Self->id,
                    'status' => Rentout::CheckOut,
                ];
                Rentout::whereIn('id', $data['rentout_ids'])->update($RentoutData);
            }
            if ($data['payments']) {
                $ChildData['checkout_id'] = $Self->id;
                $CheckoutPayment = new CheckoutPayment;
                foreach ($data['payments'] as $key => $value) {
                    $ChildData['amount'] = $value['amount'];
                    $ChildData['payment_mode'] = $value['payment_mode'];
                    $response = $CheckoutPayment->selfCreate($ChildData);
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            $Self = self::find($Self->id);
            $Self->save();
            $return['result'] = true;
            $return['message'] = 'Successfully CheckOut';
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
            $data['updated_by'] = auth()->user()->id;
            $validator = Validator::make($data, $this->rules($id));
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::find($id);
            $Self->update($data);
            if ($data['payments']) {
                $ChildData['checkout_id'] = $Self->id;
                $CheckoutPayment = new CheckoutPayment;
                foreach ($data['payments'] as $value) {
                    $ChildData['amount'] = $value['amount'];
                    $ChildData['payment_mode'] = $value['payment_mode'];
                    if(isset($value['id'])) {
                        $response = $CheckoutPayment->selfUpdate($ChildData, $value['id']);
                    } else {
                        $response = $CheckoutPayment->selfCreate($ChildData);
                    }
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Updated';
            $return['id'] = $Self->id;
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
