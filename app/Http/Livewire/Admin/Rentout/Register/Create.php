<?php

namespace App\Http\Livewire\Admin\Rentout\Register;

use App\Models\Building;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Rentout;
use App\Models\RentoutCustomer;
use App\Models\RentoutRoom;
use App\Models\Room;
use App\Models\Settings;
use App\Models\Views\RoomDateView;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Create extends Component
{
    public $RentoutType;

    public $customer_id;

    public $rentout_id;

    public $rentouts;

    public $building_id;

    public $types;

    public $Building;

    public $rentout_rooms;

    public $customers;

    public $agents;

    public $bookig_sources;

    public $companies;

    public $PaymentModes;

    public $rentout_room;

    public $Rooms;

    public $min_per_day_rent;

    protected $listeners = [
        'RentoutCreate' => 'Create',
        'RentoutRoomData',
        'AddCustomer',
        'UpdateRoomPrice',
        'SendSelectedRooms' => 'SelectedRooms',
    ];

    public function mount($rentout_id = null)
    {
        $this->rentout_id = $rentout_id;
        $this->building_id = session('building_id');
        $this->Building = Building::find($this->building_id);
        $this->Rooms = Room::buildingId($this->building_id)->orderBy('room_no')->pluck('room_no', 'id')->toArray();
        $this->types = Room::typeOptions();
        $this->rentout_rooms = [];
        $this->customers = [];
        $this->agents = [];
        $this->bookig_sources = ['Onine','Offline'];
        $this->companies = [];
        $this->PaymentModes = paymentModeOptions();
        $this->reset_rentout_room_data();
        $this->loadData();
        $BookRoom = Session::get('BookRoom');
        if($BookRoom) {
            $rentout_rooms = $BookRoom['rentout_rooms'];
            Session::forget('BookRoom');
            $this->rentout_rooms = $rentout_rooms;
            $this->emit('SelectRoom', $this->rentouts, $BookRoom['rentout_rooms']);
                $this->calculator();
        }
    }

    public function reset_rentout_room_data()
    {
        $this->rentout_room = [
            'building_id' => $this->building_id,
            'room_id' => null,
            'amount' => 0,
            'no_of_adult' => 0,
            'no_of_children' => 0,
            'check_in_date' => date('d-m-Y'),
            'check_out_date' => date('d-m-Y'),
        ];
    }

    public function loadData()
    {
        $this->min_per_day_rent = Settings::where('key', 'minimum_room_rent_building_id_'.session('building_id'))->value('values') ?? 0;
        if($this->rentout_id) {
            $Rentout = Rentout::find($this->rentout_id);
            $this->rentouts = $Rentout->toArray();
            if($Rentout->agent_id) {
                $this->agents[$Rentout->agent_id] = $Rentout->agent->first_name;
            }
            $this->rentouts['check_in_date'] = date('d-m-Y H:i', strtotime($this->rentouts['check_in_date']));
            $this->rentouts['check_out_date'] = date('d-m-Y H:i', strtotime($this->rentouts['check_out_date']));
            if($Rentout) {
                $RentoutRoom = $Rentout->rentoutrooms()->select('id', 'building_id', 'room_id', 'no_of_days', 'total', 'amount', 'no_of_adult', 'no_of_children', 'check_in_date', 'check_out_date')->get();
                foreach ($RentoutRoom as $value) {
                    $single = $value->toArray();
                    $single['room_no'] = $value->room->room_no;
                    $single['floor'] = $value->room->floor;
                    $single['no_of_beds'] = $value->room->no_of_beds;
                    $single['type'] = $value->room->type;
                    $single['status'] = $value->room->status;
                    $single['hygiene_status'] = $value->room->hygiene_status;
                    $single['price'] = $value->amount;
                    $single['no_of_days'] = $value->no_of_days;
                    $single['total'] = $value->total;
                    $id = $single['room_id'].'-'.$single['check_in_date'].'-'.$single['check_out_date'];
                    $this->rentout_rooms[$id] = $single;
                }
                $RentoutCustomers = $Rentout->rentoutCustomers()->select('id', 'customer_id')->get();
                foreach ($RentoutCustomers as $value) {
                    $single = $value->toArray();
                    $singleCustomer['id'] = $value->id;
                    $singleCustomer['customer_id'] = $value->customer_id;
                    $singleCustomer['name'] = $value->customer->full_name;
                    $singleCustomer['mobile'] = $value->customer->mobile;
                    $this->customers[$value->customer_id] = $singleCustomer;
                }
            }
        } else {
            $this->rentouts = [
                'building_id' => $this->building_id,
                'customer_id' => '',
                'reference_no' => '',
                'status' => null,
                'flag' => Rentout::Pending,
                'agent_id' => null,
                'min_per_day_rent' => $this->min_per_day_rent,
                'extra_beds' => 0,
                'single_extra_bed_charge' => Settings::where('key', 'extra_bed_charge')->value('values') ?? 0,
                'minim' => Settings::where('key', 'extra_bed_charge')->value('values') ?? 0,
                'extra_bed_charge' => 0,
                'no_of_adult' => 0,
                'no_of_children' => 0,
                'total' => 0,
                'tax_percentage' => Settings::where('key', 'tax_percentage')->value('values') ?? 0,
                'tax' => 0,
                'coupon_code' => '',
                'discount_percentage' => 0,
                'discount_amount' => 0,
                'grand_total' => 0,
                'security_deposit_payment_mode' => 'Direct Payment',
                'security_amount' => 0,
                'payment_mode' => 'Direct Payment',
                'advance_amount' => 0,
                'days' => 4,
                'check_in_date' => date('d-m-Y 14:30'),
                'check_out_date' => date('d-m-Y 12:30', strtotime('+3 days')),
            ];
        }
        $this->dayCalculator();
    }

    protected $rules = [
        'rentouts.check_in_date' => ['required'],
        'rentouts.check_out_date' => ['required'],
        'rentouts.total' => ['required'],
        'rentouts.grand_total' => ['required'],
    ];

    protected $messages = [
        'rentouts.total' => 'The rentouts total field is required',
        'rentouts.grand_total' => 'The rentouts grand total field is required',
        'rentouts.check_in_date' => 'The rentouts start date field is required',
        'rentouts.check_out_date' => 'The rentouts end date field is required',
    ];

    public function updated($key, $value)
    {
        switch ($key) {
            case 'rentouts.coupon_code':
                $this->CouponCodeCheck();
            break;
            case 'rentouts.discount_amount':
                $this->rentouts['discount_percentage'] = ($this->rentouts['total']) ? round($value * 100 / $this->rentouts['total'], 2) : 0;
                $this->updated('rentouts.discount_percentage', $this->rentouts['discount_percentage']);
            break;
            case 'rentouts.discount_percentage':
                if($value == '') {
                    $this->rentouts['discount_percentage'] = 0;
                }
                $this->rentouts['discount_amount'] = round($this->rentouts['total'] * floatval($value) / 100, 2);
                $this->rentouts['grand_total'] = round($this->rentouts['total'] - $this->rentouts['discount_amount'], 2);
                $this->calculator();
            break;
            case 'rentouts.days':
                $this->rentouts['check_out_date'] = date('d-m-Y H:i', strtotime("+$value days", strtotime($this->rentouts['check_in_date'])));
                $this->dispatchBrowserEvent('main_check_out_date_change');
            break;
            case 'rentouts.check_in_date':
                    $this->rentout_rooms = [];
            break;
            case 'rentouts.check_out_date':
                    $this->rentout_rooms = [];
            break;
            case 'rentouts.extra_beds':
                if($value == '') {
                    $this->rentouts['extra_beds'] = 0;
                }
                $this->rentouts['extra_bed_charge'] = $this->rentouts['single_extra_bed_charge'] * $this->rentouts['extra_beds'];
                $this->calculator();
                $this->CouponCodeCheck();
            break;
            case 'rentouts.no_of_adult':
                if($value == '') {
                    $this->rentouts['no_of_adult'] = 0;
                }
            break;
            case 'rentouts.no_of_children':
                if($value == '') {
                    $this->rentouts['no_of_children'] = 0;
                }
            break;
            case 'rentouts.advance_amount':
                if($value == '') {
                    $this->rentouts['advance_amount'] = 0;
                }
            break;
            case 'rentouts.security_amount':
                if($value == '') {
                    $this->rentouts['security_amount'] = 0;
                }
            break;
            case 'rentouts.check_in_date':
                if ($this->rentouts['check_out_date']) {
                    if (strtotime($this->rentouts['check_out_date']) < strtotime($value)) {
                        $this->rentouts['check_out_date'] = $value;
                    }
                } else {
                    $this->rentouts['check_out_date'] = $value;
                }
                $this->dayCalculator();
                $this->dispatchBrowserEvent('main_check_out_date_change');
            break;
            case 'rentouts.check_out_date':
                if ($this->rentouts['check_in_date']) {
                    if (strtotime($this->rentouts['check_in_date']) > strtotime($value)) {
                        $this->rentouts['check_in_date'] = $value;
                    }
                } else {
                    $this->rentouts['check_in_date'] = $value;
                }
                $this->dayCalculator();
                $this->CouponCodeCheck();
                $this->dispatchBrowserEvent('main_check_in_date_change');
            break;
        }
    }

    public function UpdateRoomPrice($key)
    {
        $this->rentout_rooms[$key]['total'] = $this->rentout_rooms[$key]['no_of_days'] * $this->rentout_rooms[$key]['price'];
        $this->calculator();
        $this->CouponCodeCheck();
    }

    public function dayCalculator()
    {
        $dates = CarbonPeriod::since(date('Y-m-d h:i:s', strtotime($this->rentouts['check_in_date'])))->days(1)->until(date('Y-m-d h:i:s', strtotime($this->rentouts['check_out_date'])))->toArray();
        $this->rentouts['days'] = count($dates);
    }

    public function Create()
    {
        $this->mount();
    }

    public function AddCustomer()
    {
        try {
            if(! $this->customer_id) {
                throw new \Exception('Please Select Any Customer', 1);
            }
            $Customer = Customer::find($this->customer_id);
            if(! $Customer) {
                throw new \Exception('Invalid Id', 1);
            }
            $single['customer_id'] = $Customer->id;
            $single['name'] = $Customer->full_name;
            $single['mobile'] = $Customer->mobile;
            if(isset($this->customers[$single['customer_id']])) {
                throw new \Exception('Already Added', 1);
            }
            $this->customers[$single['customer_id']] = $single;
            $this->DefaultCustomer();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('SelectCustomerFlag');
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function DefaultCustomer()
    {
        if(count($this->customers) == 1) {
            $this->rentouts['customer_id'] = array_key_first($this->customers);
        } else {
            if(! isset($this->customers[$this->rentouts['customer_id']])) {
                $this->rentouts['customer_id'] = array_key_first($this->customers);
            }
        }
    }

    public function RemoveCustomer($key)
    {
        try {
            DB::beginTransaction();
            if(isset($this->customers[$key]['id'])) {
                $RentoutCustomer = new RentoutCustomer;
                $response = $RentoutCustomer->selfDelete($this->customers[$key]['id']);
                if($response['result'] != 'success') throw new \Exception($response['result'], 1);
            }
            unset($this->customers[$key]);
            $this->DefaultCustomer();
            DB::commit();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully deleted the customer']);
        } catch (Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function RemoveRoom($key)
    {
        try {
            DB::beginTransaction();
            if(isset($this->rentout_rooms[$key]['id'])) {
                $RentoutRoom = new RentoutRoom;
                $response = $RentoutRoom->selfDelete($this->rentout_rooms[$key]['id']);
                if($response['result'] != 'success') throw new \Exception($response['result'], 1);
            }
            unset($this->rentout_rooms[$key]);
            $this->calculator();
            $this->CouponCodeCheck();
            DB::commit();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully deleted the room']);
        } catch (Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function SelectRoom()
    {
        $this->emit('SelectRoom', $this->rentouts, $this->rentout_rooms);
    }

    public function CouponCodeCheck()
    {
        if($this->rentouts['coupon_code']) {
        $Coupon = Coupon::where('code', $this->rentouts['coupon_code'])->notUsed()->first();
            if($Coupon) {
                $this->rentouts['coupon_id'] = $Coupon->id;
                $this->rentouts['discount_amount'] = $Coupon->amount;
                $this->updated('rentouts.discount_amount', $this->rentouts['discount_amount']);
            }
        }
    }

    public function SelectedRooms($rentout_rooms)
    {
        $this->rentout_rooms = $rentout_rooms;
        $this->calculator();
        $this->CouponCodeCheck();
    }

    public function calculator()
    {
        $rentout_rooms = collect($this->rentout_rooms);
        $this->rentouts['total'] = $rentout_rooms->sum('total');
        $this->rentouts['total'] += $this->rentouts['extra_bed_charge'];
        $this->rentouts['tax'] = round($this->rentouts['tax_percentage'] * $this->rentouts['total'] / 100, 2);
        $this->rentouts['discount_amount'] = round($this->rentouts['total'] * floatval($this->rentouts['discount_percentage']) / 100, 2);
        $this->rentouts['grand_total'] = round($this->rentouts['total'] + $this->rentouts['tax'] - $this->rentouts['discount_amount'], 2);
    }

    public function save($type)
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if(! is_numeric($this->rentouts['advance_amount'])) {
                $this->rentouts['advance_amount'] = 0;
            }
            if($this->rentouts['discount_percentage'] > 100) {
                throw new \Exception('Cant add discount % more than 100', 1);
            }
            $this->rentouts['status'] = $type;
            if ($this->rentouts['status'] == Rentout::CheckIn) {
                $dates = CarbonPeriod::since($this->rentouts['check_in_date'])->days(1)->until($this->rentouts['check_out_date'])->toArray();
                foreach ($dates as $key => $value) {
                    $dates[$key] = $value->format('Y-m-d');
                }
                $notVacant = RoomDateView::whereIn('room_id', array_column($this->rentout_rooms, 'room_id'));
                $notVacant = $notVacant->whereIn('status', [Rentout::Pending, Rentout::Booked, Rentout::CheckIn]);
                if($this->rentout_id) {
                    $notVacant = $notVacant->whereNot('rentout_id', $this->rentout_id);
                }
                $notVacant = $notVacant->whereIn('date', $dates);
                $notVacant = $notVacant->first();
                if ($notVacant) {
                    throw new \Exception('Selected Room('.$notVacant->room->room_no.') is not Vacant or in Pending State', 1);
                }
            }
            if(empty($this->rentout_rooms)) {
                $this->dispatchBrowserEvent('SelectRoomFlag');
                throw new \Exception('Please add any room', 1);
            }
            if(empty($this->customers)) {
                $this->dispatchBrowserEvent('SelectCustomerFlag');
                throw new \Exception('Please add any customer', 1);
            }
            $this->rentouts['rooms'] = collect($this->rentout_rooms);
            $min = $this->rentouts['rooms']->min('price');
            if($this->min_per_day_rent > $min) {
                throw new \Exception('Minimum per day rent should be greater than or equal to '.$this->min_per_day_rent, 1);
            }
            $this->rentouts['customers'] = $this->customers;
            $Rentout = new Rentout;
            $this->rentouts['check_in_date'] = date('Y-m-d h:i:s', strtotime($this->rentouts['check_in_date']));
            $this->rentouts['check_out_date'] = date('Y-m-d h:i:s', strtotime($this->rentouts['check_out_date']));
            if($this->rentout_id) {
                $response = $Rentout->selfUpdate($this->rentouts, $this->rentout_id);
            } else {
                $response = $Rentout->selfCreate($this->rentouts);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            if(! $this->rentout_id) {
                $message = "<a href='".route('Rentout::edit', $response['id'])."'>".$response['message'].'<br> Please Click here to goto Last Reservation</a>';
            } else {
                $message = $response['message'];
            }
            $this->dispatchBrowserEvent('success', ['message' => $message]);
            $this->mount($this->rentout_id);
            $this->dispatchBrowserEvent('FormRefreshEvent');
            DB::commit();
        } catch (\Exception $e) {
            $this->rentouts['status'] = '';
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function flagChange($flag)
    {
        $rentout = Rentout::find($this->rentout_id);
        if($rentout) {
            if($flag == Rentout::Approved) {
                if(! $rentout->registration_no) {
                    $rentout->registration_no = Rentout::GetRegistrationNo();
                }
                $rentout->status = Rentout::Booked;
            } else {
                $rentout->status = $flag;
            }
            $rentout->flag = $flag;
            $rentout->save();
            $this->mount($this->rentout_id);
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully Updated']);
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.register.create');
    }
}
