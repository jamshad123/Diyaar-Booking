<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class Rentout extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'agent_id',
        'checkout_id',
        'customer_id',
        'registration_no',
        'booking_no',
        'reference_no',
        'arrival_from',
        'purpose_of_visit',
        'check_in_date',
        'check_out_date',
        'extra_beds',
        'single_extra_bed_charge',
        'extra_bed_charge',
        'no_of_adult',
        'no_of_children',
        'total',
        'tax_percentage',
        'tax',
        'coupon_id',
        'coupon_code',
        'discount_percentage',
        'discount_amount',
        'discount_reason',
        'payment_mode',
        'advance_amount',
        'advance_reason',
        'grand_total',
        'remarks',
        'status',
        'security_deposit_payment_mode',
        'security_amount',
        'flag',
        'created_by',
        'updated_by',
    ];

    public const Pending = 'Pending';

    public const Approved = 'Approved';

    public const Rejected = 'Rejected';

    public const Booked = 'Booked';

    public const CheckIn = 'Check In';

    public const CheckOut = 'Check Out';

    public const Cancelled = 'Cancelled';

     protected $messages = [
         'building_id.required' => 'The building_id field is required',
         'customer_id.required' => 'The customer_id field is required',
         'check_in_date.required' => 'The check_in_date field is required',
         'check_out_date.required' => 'The check_out_date field is required',
         'total.required' => 'The total field is required',
         'grand_total.required' => 'The grand_total field is required',
         'extra_beds.required' => 'The extra_beds field is required',
     ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'building_id' => ['required'],
            'customer_id' => ['required'],
            'check_in_date' => ['required'],
            'check_out_date' => ['required'],
            'total' => ['required'],
            'grand_total' => ['required'],
            'extra_beds' => ['integer'],
        ], $merge);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
        });
        self::saving(function ($model) {
            if($model->status == self::CheckIn) {
                $startDate = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime($model->check_in_date)));
                $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $model->check_out_date);
                $check = Carbon::now()->between($startDate, $endDate);
                if(! $check) {
                    throw new \Exception('You Cant Check In Now , Current date is ('.systemDateTime(now()).')');
                }
            }
        });
    }

    public static function statusOptions()
    {
        return [
            self::Pending => 'Pending',
            self::Booked => 'Booked',
            self::CheckIn => 'Check In',
            self::CheckOut => 'Check Out',
            self::Cancelled => 'Cancelled',
            self::Rejected => 'Rejected',
        ];
    }

    public static function flagOptions()
    {
        return [
            self::Approved => 'Approved',
            self::Pending => 'Pending',
            self::Rejected => 'Rejected',
        ];
    }

    public function scopeBuildingId($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('building_id', $value);
        });
    }

    public function scopeCheckIn($query)
    {
        return $query->where('status', self::CheckIn);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class, 'rentout_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rentoutCustomers()
    {
        return $this->hasMany(RentoutCustomer::class, 'rentout_id');
    }

    public function rentoutRooms()
    {
        return $this->hasMany(RentoutRoom::class, 'rentout_id');
    }

    public function days()
    {
        $dates = CarbonPeriod::since(date('Y-m-d', strtotime($this->check_in_date)))->days(1)->until(date('Y-m-d', strtotime($this->check_out_date)))->toArray();

        return count($dates);
    }

    public function roomDates()
    {
        return $this->hasMany(\App\Models\Views\RoomDateView::class, 'rentout_id', 'id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function GetBookingNo()
    {
        return self::count() + 1;
    }

    public static function GetRegistrationNo()
    {
        return self::where('flag', self::Approved)->max('registration_no') + 1;
    }

    public function selfCreate($data)
    {
        try {
            $data['created_by'] = auth()->user()->id;
            $data['updated_by'] = auth()->user()->id;
            $data['agent_id'] = $data['agent_id'] ? $data['agent_id'] : null;
            $data['booking_no'] = $this->GetBookingNo();
            $data['flag'] = self::Pending;
            if($data['status'] == self::CheckIn) {
                $data['registration_no'] = $this->GetRegistrationNo();
            }
            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($key.'-'.$value[0]);
                }
            }
            $Self = self::create($data);
            if(isset($data['coupon_id'])) {
                $Coupon = new Coupon;
                $CouponData['rentout_id'] = $Self->id;
                $CouponData['used_by'] = $Self->created_by;
                $response = $Coupon->selfUpdate($CouponData, $data['coupon_id']);
                if (! $response['result']) {
                    throw new \Exception($response['message'], 1);
                }
            }
            if ($data['rooms']) {
                $ChildData['rentout_id'] = $Self->id;
                $ChildData['customer_id'] = $Self->customer_id;
                $ChildData['building_id'] = $Self->building_id;
                $ChildData['status'] = $Self->status;
                $RentoutRoom = new RentoutRoom;
                foreach ($data['rooms'] as $key => $value) {
                    $ChildData['room_id'] = $value['room_id'];
                    $ChildData['check_in_date'] = date('Y-m-d', strtotime($value['check_in_date']));
                    $ChildData['check_out_date'] = date('Y-m-d', strtotime($value['check_out_date']));
                    $ChildData['check_in_time'] = date('h:i:s', strtotime($Self['check_in_date']));
                    $ChildData['check_out_time'] = date('h:i:s', strtotime($Self['check_out_date']));
                    $ChildData['no_of_days'] = $value['no_of_days'];
                    $ChildData['total'] = $value['total'];
                    $ChildData['amount'] = $value['price'];
                    $response = $RentoutRoom->selfCreate($ChildData);
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            if ($data['customers']) {
                $ChildData['rentout_id'] = $Self->id;
                $RentoutCustomer = new RentoutCustomer;
                foreach ($data['customers'] as $key => $value) {
                    $ChildData['customer_id'] = $value['customer_id'];
                    $response = $RentoutCustomer->selfCreate($ChildData);
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            $return['result'] = true;
            $return['message'] = 'Successfully '.$Self->status;
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
            $data['agent_id'] = $data['agent_id'] ? $data['agent_id'] : null;
            $validator = Validator::make($data, $this->rules($id));
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new \Exception($value[0]);
                }
            }
            $Self = self::find($id);
            $OldSelf = clone $Self;
            if($Self->flag == self::Pending && $data['flag'] == self::Pending) {
                // return self::where('flag', self::Approved)->count() + 1;
            }
            $Self->update($data);
            if($OldSelf['coupon_id'] != $Self['coupon_id']) {
                if($OldSelf->coupon) {
                    $OldSelf->coupon->rentout_id = null;
                    $OldSelf->coupon->used_by = null;
                    $OldSelf->coupon->save();
                }
                if($data['coupon_id']) {
                    $Coupon = new Coupon;
                    $CouponData['rentout_id'] = $Self->id;
                    $CouponData['used_by'] = $Self->created_by;
                    $response = $Coupon->selfUpdate($CouponData, $data['coupon_id']);
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            if ($data['rooms']) {
                $ChildData['rentout_id'] = $Self->id;
                $ChildData['customer_id'] = $Self->customer_id;
                $ChildData['building_id'] = $Self->building_id;
                $ChildData['status'] = $Self->status;
                $RentoutRoom = new RentoutRoom;
                foreach ($data['rooms'] as $key => $value) {
                    $ChildData['room_id'] = $value['room_id'];
                    $ChildData['check_in_date'] = date('Y-m-d', strtotime($value['check_in_date']));
                    $ChildData['check_out_date'] = date('Y-m-d', strtotime($value['check_out_date']));
                    $ChildData['check_in_time'] = date('h:i:s', strtotime($Self['check_in_date']));
                    $ChildData['check_out_time'] = date('h:i:s', strtotime($Self['check_out_date']));
                    $ChildData['no_of_days'] = $value['no_of_days'];
                    $ChildData['total'] = $value['total'];
                    $ChildData['amount'] = $value['price'];
                    if(isset($value['id'])) {
                        $response = $RentoutRoom->selfUpdate($ChildData, $value['id']);
                    } else {
                        $response = $RentoutRoom->selfCreate($ChildData);
                    }
                    if (! $response['result']) {
                        throw new \Exception($response['message'], 1);
                    }
                }
            }
            if ($data['customers']) {
                $ChildData['rentout_id'] = $Self->id;
                $RentoutCustomer = new RentoutCustomer;
                foreach ($data['customers'] as $key => $value) {
                    $ChildData['customer_id'] = $value['customer_id'];
                    if(isset($value['id'])) {
                        $response = $RentoutCustomer->selfUpdate($ChildData, $value['id']);
                    } else {
                        $response = $RentoutCustomer->selfCreate($ChildData);
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
