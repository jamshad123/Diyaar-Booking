<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Library\Facades\Permissions;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'CustomerMultiDelete' => 'MultiDelete',
    ];

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Customer = new Customer;
            foreach ($ids as  $id) {
                $response = $Customer->selfDelete($id);
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

    public function render(Builder $htmlBuilder)
    {
        $Column = Column::make('id');
        $Column->checkboxes([
            'selectRow' => true,
            'selectAllRender' => '<input type="checkbox" class="form-check-input">',
        ]);
        $Column->searchable(true)->visible(true)->orderable(false);
        $Columns[] = $Column->title('#');
        $Columns[] = Column::make('first_name')->searchable(true)->visible(true)->title('First Name');
        $Columns[] = Column::make('last_name')->searchable(true)->visible(true)->title('Last Name');
        $Columns[] = Column::make('customer_type')->searchable(true)->visible(true)->title('Customer Type');
        $Columns[] = Column::make('mobile')->searchable(true)->visible(true)->title('mobile');
        $Columns[] = Column::make('email')->searchable(true)->visible(false)->title('email');
        $Columns[] = Column::make('father_name')->searchable(true)->visible(false)->title('father name');
        $Columns[] = Column::make('occupation')->searchable(true)->visible(false)->title('occupation');
        $Columns[] = Column::make('date_of_birth')->searchable(true)->visible(false)->title('date of birth');
        $Columns[] = Column::make('gender')->searchable(true)->visible(true)->title('gender');
        $Columns[] = Column::make('country')->searchable(true)->visible(true)->title('country');
        $Columns[] = Column::make('state')->searchable(true)->visible(false)->title('state');
        $Columns[] = Column::make('city')->searchable(true)->visible(false)->title('city');
        $Columns[] = Column::make('zip_code')->searchable(true)->visible(false)->title('zip_code');
        $Columns[] = Column::make('document_type')->searchable(true)->visible(true)->title('document type');
        $Columns[] = Column::make('address')->searchable(true)->visible(false)->title('address');
        if(Permissions::Allow('Customer.Edit')) {
            $Columns[] = Column::make('action')->searchable(true)->visible(true)->title('action');
        }
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Customer::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token = "'.csrf_token().'";
                d.customer_type = $("#customer_type").val();
                d.document_type = $("#document_type").val();
                d.gender = $("#gender").val();
                d.country = $("#country").val();
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
        $dom = '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>';
        $actionButton[] = [
            'extend' => 'collection',
            'className' => 'btn btn-label-secondary dropdown-toggle mx-3',
            'text' => '<i class="bx bx-upload me-2"></i>Export',
            'buttons' => $buttons,
        ];
        if(Permissions::Allow('Customer.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("CustomerMultiDelete",selectedId);
                }',
            ];
        }

        if(Permissions::Allow('Customer.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New Customer</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    window.livewire.emit("CreateCustomer");
                    $("#CustomerModal").modal("show");
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

        return view('livewire.admin.customer.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
