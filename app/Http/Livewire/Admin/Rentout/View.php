<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\CheckoutPayment;
use App\Models\Rentout;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public $rentout_id;

    public $rentout;

    protected $listeners = [
        'RefreshViewComponent' => 'refreshComponent',
    ];

    public function refreshComponent()
    {
        $this->mount($this->rentout_id);
    }

    public function mount($rentout_id)
    {
        $this->rentout_id = $rentout_id;
        $this->rentout = Rentout::find($rentout_id);
        if (! $this->rentout) {
            return redirect(route('Rentout::List'));
        }
    }

    public function RemovePayment($id)
    {
        try {
            DB::beginTransaction();
            $CheckoutPayment = new CheckoutPayment;
            $response = $CheckoutPayment->selfDelete($id);
            if($response['result'] != 'success') throw new \Exception($response['result'], 1);
            $this->refreshComponent();
            DB::commit();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully deleted the payment']);
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.view');
    }
}
