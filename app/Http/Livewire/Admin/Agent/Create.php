<?php

namespace App\Http\Livewire\Admin\Agent;

use App\Models\Agent;
use Countries;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $country_disable = '';

    public $closeFlag = true;

    public $table_id;

    public $Countries;

    public $agents;

    public $Agent;

    protected $listeners = [
        'EditAgent' => 'Edit',
        'CreateAgent' => 'Create',
    ];

    protected $rules = [
        'agents.first_name' => ['required'],
        'agents.customer_type' => ['required'],
        'agents.document_type' => ['required'],
        'agents.gender' => ['required'],
        'agents.mobile' => ['required'],
    ];

    protected $messages = [
        'agents.first_name' => 'The agents First Name field is required',
        'agents.customer_type' => 'The agents type field is required',
        'agents.document_type' => 'The document type field is required',
        'agents.gender' => 'The gender field is required',
        'agents.mobile' => 'The agents Mobile field is required',
    ];

    public function mount($table_id = null)
    {
        $this->table_id = $table_id;
        $this->Countries = Countries::getList('en');
        if ($table_id) {
            $this->Agent = Agent::find($this->table_id);
            $this->agents = $this->Agent->toArray();
        } else {
            $this->agents = [
                'first_name' => '',
                'mobile' => '',
                'document_type' => '',
                'gender' => 'Male',
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
        if($key == 'agents.customer_type') {
            switch ($value) {
                case Agent::Citizen:
                    $this->country_disable = 'disabled';
                    $this->agents['country'] = 'SA';
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
            $Agent = new Agent;
            if ($this->table_id) {
                $response = $Agent->selfUpdate($this->agents, $this->table_id);
            } else {
                $response = $Agent->selfCreate($this->agents);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $text = $this->agents['first_name'];
            $table_id = $response['id'];
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->dispatchBrowserEvent('TableDraw');
            $this->mount($this->table_id);
            DB::commit();
            if ($this->closeFlag) {
                $this->dispatchBrowserEvent('CloseAgentModal');
            }
            $this->dispatchBrowserEvent('AppendAgentLastData', ['id' => $table_id, 'text' => $text]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.agent.create');
    }
}
