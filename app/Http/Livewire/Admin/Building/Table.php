<?php

namespace App\Http\Livewire\Admin\Building;

use App\Library\Facades\Permissions;
use App\Models\Building;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    protected $listeners = [
        'BuildingMultiDelete' => 'MultiDelete',
    ];

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Building = new Building;
            foreach ($ids as  $id) {
                $response = $Building->selfDelete($id);
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
        $Columns[] = Column::make('name')->width('50%')->searchable(true)->visible(true)->title('name');
        $Columns[] = Column::make('Occupied')->width('10%')->searchable(true)->visible(true)->className('text-end')->title('Occupied');
        $Columns[] = Column::make('Vacant')->width('10%')->searchable(true)->visible(true)->className('text-end')->title('Vacant');
        $Columns[] = Column::make('Booked')->width('10%')->searchable(true)->visible(true)->className('text-end')->title('Booked');
        $Columns[] = Column::make('Active')->width('10%')->searchable(true)->visible(true)->className('text-end')->title('Active');
        $Columns[] = Column::make('Maintenance')->width('10%')->searchable(true)->visible(true)->className('text-end')->title('Maintenance');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Building::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token = "'.csrf_token().'";
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
        if(Permissions::Allow('Building.Delete')) {
            $actionButton[] = [
                'text' => '<i class="bx bx-trash me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Delete Selected</span>',
                'className' => 'btn btn-secondary',
                'action' => 'function ( e, dt, node, config ) {
                    selectedRows = dataTable.rows(".selected").data();
                    selectedId=[];
                    selectedRows.each((item, i) => { selectedId.push(item.id); });
                    if(!selectedId.length){ Swal.fire( "Info!", "Please Select Any Row To Delete it", "info" ); return false }
                    if(!confirm("Are You Sure To Delete Selected("+selectedId.length+") Rows!")){ return false; }
                    window.livewire.emit("BuildingMultiDelete",selectedId);
                }',
            ];
        }
        if(Permissions::Allow('Building.Create')) {
            $actionButton[] = [
                'text' => '<i class ="bx bx-plus me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Add New Building</span>',
                'className' => 'add-new btn btn-primary',
                'action' => 'function ( e, dt, node, config ) {
                    $("#BuildingCreateModal").modal("show");
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

        return view('livewire.admin.building.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
