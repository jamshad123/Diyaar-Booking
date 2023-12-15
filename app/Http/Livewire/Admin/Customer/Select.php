<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Models\Customer;
use Livewire\Component;

class Select extends Component
{
    protected $listeners = [
        'searchCustomer' => 'search',
    ];

    public $search_tag = '';

    public function mount()
    {
        $this->customers = [];
        $this->countries = [];
        $this->companies = [];
    }

    public function updated($key, $value)
    {
        $this->search();
    }

    public function search()
    {
        if($this->search_tag) {
            $data['search_tag'] = $this->search_tag;
            $this->customers = Customer::CustomerSearchData($data)->orderBy('first_name')->get(['first_name', 'last_name', 'mobile', 'id']);
        } else {
            $this->customers = [];
        }
    }

    public function addCustomer($id)
    {
        $this->dispatchBrowserEvent('AppendNewCustomerToDataTable', ['id' => $id]);
    }

    public function save()
    {

    }

    public function render()
    {
        return view('livewire.admin.customer.select');
    }
}
