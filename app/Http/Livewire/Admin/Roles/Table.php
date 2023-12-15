<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Library\Facades\Permissions;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'RoleMultiDelete' => 'MultiDelete',
    ];

    public $role_id;

    public function mount($role_id = null)
    {
        $this->role_id = $role_id;
    }

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Role = new Role;
            foreach ($ids as  $id) {
                $response = $Role->selfDelete($id);
                if (! $response['result']) {
                    throw new \Exception($response['message'], 1);
                }
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();
            $this->dispatchBrowserEvent('TableDraw');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function datatable(Request $request)
    {
        $datas = new Role;
        $datas = $datas->orderBy('name');

        return Datatables::of($datas)
        ->editColumn('action', function ($value) {
            $return = "<i table_id='".$value->id."' class='fa fa-2x fa-edit edit'></i>";

            return $return;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function render(Builder $htmlBuilder)
    {
        $Column = Column::make('id');
        $Column->checkboxes([
            'selectRow' => true,
            'selectAllRender' => '<input type="checkbox" class="form-check-input">',
        ]);
        $Column->searchable(true)->visible(true);
        $Columns[] = $Column->title('#');
        $Columns[] = Column::make('name')->searchable(true)->visible(true)->title('name');
        $Columns[] = Column::make('description')->width('60%')->searchable(true)->visible(true)->title('Description');
        if(Permissions::Allow('Role.Edit')) {
            $Columns[] = Column::make('action')->searchable(false)->orderable(true)->title('Action');
        }
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('roles::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token = "'.csrf_token().'";
            }',
        ]);
        $dom = '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>';
        $actionButton = [];
        if(Permissions::Allow('Role.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("RoleMultiDelete",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Role.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New Role</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    window.livewire.emit("CreateRole");
                    $("#RoleModal").modal("show");
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
            'select' => [
                'style' => 'multi',
            ],
        ]);

        return view('livewire.admin.roles.table')
            ->with('htmlBuilder', $htmlBuilder);
    }
}
