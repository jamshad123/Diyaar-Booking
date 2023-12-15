<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;

class Room extends Model implements AuditableContracts
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    public const Clean = 'Clean';

    public const Dirty = 'Dirty';

    public const Double = 'Double';

    public const Triple = 'Triple';

    public const Quad = 'Quad';

    public const Quint = 'Quint';

    public const King = 'King';

    public const Pending = 'Pending';

    public const Booked = 'Booked';

    public const Occupied = 'Occupied';

    public const CheckIn = 'Check In';

    public const Vacant = 'Vacant';

    public const Active = 'Active';

    public const InActive = 'InActive';

    public const Maintenance = 'Maintenance';

    protected $fillable = [
        'building_id',
        'room_no',
        'floor',
        'type',
        'capacity',
        'extra_capacity',
        'no_of_beds',
        'amount',
        'hygiene_status',
        'status',
        'building_id',
        'description',
        'reserve_condition',
    ];

    public static function typeOptions()
    {
        return [
            self::Double => 'Double',
            self::Triple => 'Triple',
            self::Quad => 'Quad',
            self::Quint => 'Quint',
            self::King => 'King',
        ];
    }

    public static function hygieneStatusOptions()
    {
        return [
            self::Clean => 'Clean',
            self::Dirty => 'Dirty',
        ];
    }

    public static function statusOptions()
    {
        return [
            self::Active => 'Active',
            self::Maintenance => 'Maintenance',
            self::InActive => 'InActive',
        ];
    }

    public function scopeBuildingId($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('rooms.building_id', $value);
        });
    }

    public function scopeFloor($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('floor', $value);
        });
    }

    public function scopeType($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('type', $value);
        });
    }

    public function scopeStatus($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('status', $value);
        });
    }

    public function scopeVacant($query)
    {
        return $query->where('status', 'Vacant');
    }

    public function scopeNotVacant($query)
    {
        return $query->where('status', '!=', 'Vacant');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'Occupied');
    }

    public function scopeHygieneStatus($query, $id)
    {
        return $query->when($id ?? '', function ($q, $value) {
            return $q->where('hygiene_status', $value);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::Active);
    }

    public function scopeGroupCount($query, $column)
    {
        return $query->groupBy($column)->select("$column as name", DB::raw("count($column) as count"));
    }

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'building_id' => ['required'],
            'room_no' => ['required'],
            'type' => ['required'],
        ], $merge);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
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
                throw new \Exception('Cant Delete This Room'.$id, 1);
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
        $Self = self::orderBy('room_no');
        $Self = $Self->when($data['search_tag'] ?? '', function ($q, $value) {
            return $q->where('room_no', 'like', "%{$value}%");
        });
        $Self = $Self->when($data['building_id'] ?? '', function ($q, $value) {
            return $q->where('building_id', $value);
        });
        $Self = $Self->when($data['type'] ?? '', function ($q, $value) {
            return $q->where('type', $value);
        });
        $Self = $Self->get(['room_no as name', 'id'])->toArray();
        $prepend['id'] = 0;
        $prepend['name'] = 'All';
        $Self = Arr::prepend($Self, $prepend);
        $return['items'] = $Self;

        return $return;
    }
}
