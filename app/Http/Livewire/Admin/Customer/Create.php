<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Models\Customer;
use Countries;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $country_disable = '';

    public $closeFlag = true;

    public $table_id;

    public $Countries;

    public $customers;

    public $Customer;

    protected $listeners = [
        'EditCustomer' => 'Edit',
        'CreateCustomer' => 'Create',
    ];

    protected $rules = [
        'customers.first_name' => ['required'],
        'customers.customer_type' => ['required'],
        'customers.document_type' => ['required'],
        'customers.gender' => ['required'],
        'customers.mobile' => ['required'],
    ];

    protected $messages = [
        'customers.first_name' => 'The customers First Name field is required',
        'customers.customer_type' => 'The customers type field is required',
        'customers.document_type' => 'The document type field is required',
        'customers.gender' => 'The gender field is required',
        'customers.mobile' => 'The customers Mobile field is required',
    ];

    public function mount($table_id = null)
    {
        $this->table_id = $table_id;
        $this->Countries = Countries::getList('en');
        if ($table_id) {
            $this->Customer = Customer::find($this->table_id);
            $this->customers = $this->Customer->toArray();
        } else {
            $this->customers = [
                'first_name' => '',
                'mobile' => '',
                'document_type' => '',
                'gender' => 'Male',
                'id_no' => '',
                'passport_no' => '',
                'visa_no' => '',
                'iqama_no' => '',
                'qccid_no' => '',
            ];
        }
    }

    public function Create()
    {
        $this->mount();
    }

    public function Edit($id)
    {
        $this->mount($id);
    }

    public function updated($key, $value)
    {
        if($key == 'customers.customer_type') {
            switch ($value) {
                case Customer::Citizen:
                    $this->country_disable = 'disabled';
                    $this->customers['country'] = 'SA';
                    break;
                    default:
                        $this->country_disable = '';
                    break;
            }
        }
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $Customer = new Customer;
            switch ($this->customers['document_type']) {
                case Customer::IDCard:
                    if(! $this->customers['id_no']) {
                        throw new \Exception('Id No Required', 1);
                    }
                    break;
                case Customer::Passport:
                    if(! $this->customers['passport_no']) {
                        throw new \Exception('Passport No Required', 1);
                    }
                    if(! $this->customers['visa_no']) {
                        throw new \Exception('Visa No Required', 1);
                    }
                    break;
                case Customer::ResidencePermit:
                    if(! $this->customers['iqama_no']) {
                        throw new \Exception('Iqama No Required', 1);
                    }
                    break;
                case Customer::GCCID:
                    if(! $this->customers['qccid_no']) {
                        throw new \Exception('QCCID No Required', 1);
                    }
                    break;
            }
            if ($this->table_id) {
                $response = $Customer->selfUpdate($this->customers, $this->table_id);
            } else {
                $response = $Customer->selfCreate($this->customers);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $text = $this->customers['first_name'];
            $table_id = $response['id'];
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->dispatchBrowserEvent('TableDraw');
            $this->mount($this->table_id);
            DB::commit();
            if ($this->closeFlag) {
                $this->dispatchBrowserEvent('CloseCustomerModal');
            }
            $this->dispatchBrowserEvent('AppendCustomerLastData', ['id' => $table_id, 'text' => $text]);
            $this->dispatchBrowserEvent('AppendNewCustomerToDataTable', ['id' => $table_id]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.customer.create');
    }
}
