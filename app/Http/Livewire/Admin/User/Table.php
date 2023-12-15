<?php

namespace App\Http\Livewire\Admin\User;

use App\Library\Facades\Permissions;
use App\Models\User;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    public $totalUsers;

    public function mount()
    {
        $this->totalUsers = User::count();
    }

    public function render(Builder $htmlBuilder)
    {
        $Columns[] = Column::make('id')->searchable(true)->visible(true)->title('#');
        $Columns[] = Column::make('name')->searchable(true)->visible(true)->title('name');
        $Columns[] = Column::make('email')->searchable(true)->visible(true)->title('email');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('User::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token       = "'.csrf_token().'";
                d.user_role_id = $("#user_role_id").val();
            }',
        ]);
        $buttons[] = [
            'extend' => 'pdf',
            'text' => '<i class ="bx bxs-file-pdf me-2"></i>Pdf',
            'className' => 'dropdown-item',
        ];
        $buttons[] = [
            'extend' => 'excel',
            'text' => '<i class="bx bxs-file-excel me-2"></i>Excel',
            'className' => 'dropdown-item',
        ];
        $dom = '<"row mx-2"';
        $dom .= '    <"col-md-2"<"me-3"l>>';
        $dom .= '    <"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>';
        $dom .= '>';
        $actionButton[] = [
            'extend' => 'collection',
            'className' => 'btn btn-label-secondary dropdown-toggle mx-3',
            'text' => '<i class="bx bx-upload me-2"></i>Export',
            'buttons' => $buttons,
        ];
        if(Permissions::Allow('User.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New User</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    $("#UserModal").modal("show");
                }',
            ];
        }

        $htmlBuilder->parameters([
            'lengthMenu' => [[10, 50, 100, '-1'], [10, 50, 100, 'All']],
            'order' => [[1, 'desc']],
            'dom' => $dom,
            'language' => [
                'sLengthMenu' => '_MENU_',
                'search' => '',
                'searchPlaceholder' => 'Search..',
            ],
            'buttons' => $actionButton,
        ]);

        return view('livewire.admin.user.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
