<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Role extends Model
{
    use HasFactory;

    public const SuperAdmin = 1;

    public const Admin = 2;

    public const MD = 2;

    public const Supervisor = 3;

    public const Manager = 4;

    public const Receptionist = 5;

    public const Collection = 6;

    protected $fillable = [
        'name',
        'description',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'name' => ['required', 'unique:roles'.($id ? ",name,$id" : '')],
        ], $merge);
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id');
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
            if(isset($data['permission'])) {
                RolePermission::where('role_id', $Self->id)->delete();
                $RolePermission = new RolePermission;
                $single['role_id'] = $Self->id;
                foreach($data['permission'] as $permission => $checking) {
                    if($checking) {
                        $single['permission_id'] = $permission;
                        $response = $RolePermission->selfCreate($single);
                        if(! $response['result']) throw new \Exception($response['message']);
                    }
                }
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Created';
            $return['id'] = $Self->id;
            $return['name'] = $Self->name;
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
            if(isset($data['permission'])) {
                RolePermission::where('role_id', $Self->id)->delete();
                $RolePermission = new RolePermission;
                $single['role_id'] = $Self->id;
                foreach($data['permission'] as $permission => $checking) {
                    if($checking) {
                        $single['permission_id'] = $permission;
                        $response = $RolePermission->selfCreate($single);
                        if(! $response['result']) throw new \Exception($response['message']);
                    }
                }
            }
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
            if ($Self->flag == 1) {
                throw new \Exception('Cant Delete this role its flagged', 1);
            }
            if (! $Self->delete()) {
                throw new \Exception('Cant Delete This Building'.$id, 1);
            }
            $return['result'] = true;
            $return['message'] = 'Successfully Deleted';
        } catch (\Exception $e) {
            $return['result'] = false;
            $return['message'] = $e->getMessage();
        }

        return $return;
    }

    public function getDropDownList($data)
    {
        $type = $data['type'] ?? '';
        $list = $data['list'] ?? true;
        $Self = self::orderBy('name');
        $Self = $Self->when($data['search_tag'] ?? '', function ($q, $value) {
            return $q->where('name', 'like', "%{$value}%");
        });
        $Self = $Self->get(['name', 'id'])->toArray();
        if ($list) {
            $prepend['id'] = 0;
            $prepend['name'] = 'All';
            $Self = Arr::prepend($Self, $prepend);
        }
        $return['items'] = $Self;

        return $return;
    }
}
