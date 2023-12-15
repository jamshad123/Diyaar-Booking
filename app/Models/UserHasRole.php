<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class UserHasRole extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'user_id' => ['required'],
            'role_id' => ['required'],
        ], $merge);
    }

    public function role()
    {
        return $this->hasMbelongsToany(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roleAssign($data)
    {
        $Self = self::where('user_id', $data['user_id'])->where('role_id', $data['role_id'])->count();
        if(! $Self) {
            $response = $this->selfCreate($data);
        } else {
            $response = $this->selfDelete($data);
        }

        return $response;
    }

    public function selfCreate($data)
    {
        try {
            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    throw new Exception($value[0]);
                }
            }
            $Self = self::create($data);
            $return['result'] = true;
            $return['message'] = 'Successfully Created';
        } catch (Exception $e) {
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
                throw new Exception('Cant Delete This User Role'.$id, 1);
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Deleted';
        } catch (Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }
}
