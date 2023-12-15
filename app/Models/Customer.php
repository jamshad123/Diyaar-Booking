<?php

namespace App\Models;

use App\Library\Facades\Permissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class Customer extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    public const Citizen = 'Citizen';

    public const Foreigner = 'Foreigner';

    public const GulfCitizen = 'Gulf Citizen';

    public const Visitor = 'Visitor';

    public const IDCard = 'ID Card';

    public const Passport = 'Passport';

    public const ResidencePermit = 'Residence Permit';

    public const GCCID = 'GCC ID';

    public const Male = 'Male';

    public const Female = 'Female';

    protected $fillable = [
        'first_name',
        'second_name',
        'middle_name',
        'customer_type',
        'last_name',
        'mobile',
        'email',
        'father_name',
        'gender',
        'occupation',
        'date_of_birth',
        'anniversary',
        'nationality',
        'country',
        'state',
        'city',
        'zip_code',
        'address',
        'comments',
        'document_type',
        'id_no',
        'iqama_no',
        'visa_no',
        'passport_no',
        'qccid_no',
        'issue_place',
        'expiry_date',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'first_name' => ['required'],
            'customer_type' => ['required'],
            'gender' => ['required'],
            'mobile' => ['required'],
        ], $merge);
    }

    public function Rentouts()
    {
        return $this->hasMany(Rentout::class, 'customer_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name ?? '';
    }

    public function documentType()
    {
        $return = [];
        switch($this->document_type) {
            case Customer::IDCard:
            $return['title'] = Customer::IDCard;
            $return['field']['Id No'] = $this->id_no;
            break;
            case Customer::Passport:
            $return['title'] = Customer::Passport;
            $return['field']['Passport No'] = $this->passport_no;
            $return['field']['Visa No'] = $this->visa_no;
            break;
            case Customer::ResidencePermit:
            $return['title'] = Customer::ResidencePermit;
            $return['field']['Iqama No'] = $this->iqama_no;
            break;
            case Customer::GCCID:
            $return['title'] = Customer::GCCID;
            $return['field']['QCCID No'] = $this->qccid_no;
            break;
        }

        return $return;
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
            $Dup = self::where([['first_name', $data['first_name']], ['mobile', $data['mobile']]])->first();
            if ($Dup) {
                throw new \Exception('This Customer Already Added', 1);
            }
            $Self = self::create($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Created';
            $return['id'] = $Self->id;
            $return['first_name'] = $Self->first_name;
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
                throw new \Exception('Cant Delete This Customer'.$id, 1);
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Deleted';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public static function CustomerSearchData($data)
    {
        $Self = new self;
        $Self = $Self->when($data['search_tag'] ?? '', function ($q, $value) {
            $q->where('first_name', 'like', "%{$value}%");
            $q->orWhere('last_name', 'like', "%{$value}%");
            $q->orWhere('mobile', 'like', "%{$value}%");

            return $q;
        });

        return $Self;
    }

    public function getDropDownList($data)
    {
        $type = $data['type'] ?? '';
        $Self = $this->CustomerSearchData($data);
        $Self = $Self->orderBy('first_name');
        $Self = $Self->get([DB::raw("CONCAT(first_name,' ',IFNULL(last_name,''),' - ', mobile) as name"), 'id']);
        $Self = $Self->toArray();
        $prepend['id'] = 0;
        $prepend['name'] = 'All';
        $Self = Arr::prepend($Self, $prepend);
        if(Permissions::Allow('Customer.Create')) {
            if ($type != 'list') {
                $single['id'] = 'Add';
                $single['name'] = '---- Add New ----';
                if (! isset($data['list'])) {
                    $Self[] = $single;
                }
            }
        }
        $return['items'] = $Self;

        return $return;
    }
}
