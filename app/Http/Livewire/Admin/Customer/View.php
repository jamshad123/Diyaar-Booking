<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Models\Customer;
use Livewire\Component;

class View extends Component
{
    protected $listeners = [
        'CustomerViewComponent' => 'refreshComponent',
    ];

    public function refreshComponent()
    {
        $this->mount($this->table_id);
    }

    public function mount($id)
    {
        $this->table_id = $id;
        $this->Customer = Customer::find($id);
        $this->buildings = $this->Customer->toArray();
    }

    public function render()
    {
        return view('livewire.admin.customer.view');
    }
}
