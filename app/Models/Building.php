<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class Building extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'name' => ['required', 'unique:buildings'.($id ? ",name,$id" : '')],
        ], $merge);
    }

    public function Rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }

    public function selfCreate($data)
    {
        try {
            $Self = self::onlyTrashed()->where('name', $data['name'])->first();
            if (! $Self) {
                $validator = Validator::make($data, $this->rules());
                if ($validator->fails()) {
                    foreach ($validator->errors()->getMessages() as $key => $value) {
                        throw new \Exception($value[0]);
                    }
                }
                $Self = self::create($data);
            } else {
                $Self->restore();
                $id = $Self->id;
                $validator = Validator::make($data, $this->rules($id));
                if ($validator->fails()) {
                    foreach ($validator->errors()->getMessages() as $key => $value) {
                        throw new \Exception($value[0]);
                    }
                }
                $Self->update($data);
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
