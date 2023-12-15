<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use Shetabit\Visitor\Traits\Visitor as VisitorTrait;

class User extends Authenticatable implements AuditableContracts
{
    use VisitorTrait;
    use Auditable;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    const Active = 1;

    const Suspended = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'flag',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'name' => ['required'],
            'email' => ['required', 'unique:users'.($id ? ",email,$id" : '')],
            'password' => ['required'],
        ], $merge);
    }

    public function roles()
    {
        return $this->hasMany(UserHasRole::class, 'user_id');
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'visitor_id', 'id')->latest();
    }

    public function selfCreate($data)
    {
        try {
            $data['flag'] = self::Suspended;
            $data['password'] = Hash::make($data['password']);
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
}
