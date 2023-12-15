<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Visitor;
use Livewire\Component;
use Livewire\WithPagination;

class VisitHistory extends Component
{
    use WithPagination;

    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $lists = new Visitor;
        $lists = $lists->where('visitor_id', $this->user_id);
        $lists = $lists->latest();
        $lists = $lists->paginate(10);

        return view('livewire.admin.user.visit-history')->with('lists', $lists);
    }
}
