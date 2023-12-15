<?php

namespace App\Http\Livewire\Admin\Collection;

use App\Models\User;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Table extends Component
{
    public function mount()
    {
        $this->users = User::pluck('name', 'id')->toArray();
        $this->from_date = date('d-m-Y 0:0:0');
        $this->to_date = date('d-m-Y H:i');
    }

    public function render(Builder $htmlBuilder)
    {
        $Column = Column::make('id')->searchable(true)->visible(true)->orderable(false);
        $Columns[] = $Column->title('#');
        $Columns[] = Column::make('user_id')->searchable(true)->visible(true)->title('User');
        $Columns[] = Column::make('opening_time')->searchable(true)->visible(true)->title('opening Time');
        $Columns[] = Column::make('opening_balance')->searchable(true)->visible(true)->className('text-end')->title('Opening Balance');
        $Columns[] = Column::make('opening_note')->searchable(true)->visible(true)->title('Opening Note');
        $Columns[] = Column::make('closing_time')->searchable(true)->visible(true)->title('Closing Time');
        $Columns[] = Column::make('closing_balance')->searchable(true)->visible(true)->className('text-end')->title('Closing Balance');
        $Columns[] = Column::make('closing_note')->searchable(true)->visible(true)->title('Closing Note');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Collection::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token    = "'.csrf_token().'";
                d.user_id   = $("#user_id").val();
                d.from_date = $("#from_date").val();
                d.to_date   = $("#to_date").val();
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
        $htmlBuilder->parameters([
            'lengthMenu' => [[10, 50, 100, '-1'], [10, 50, 100, 'All']],
            'order' => [[1, 'desc']],
            'dom' => $dom,
            'language' => [
                'sLengthMenu' => '_MENU_',
                'search' => '',
                'searchPlaceholder' => 'Search..',
            ],
            'buttons' => [
                [
                    'extend' => 'collection',
                    'className' => 'btn btn-label-secondary dropdown-toggle mx-3',
                    'text' => '<i class="bx bx-upload me-2"></i>Export',
                    'buttons' => $buttons,
                ],
            ],
        ]);

        return view('livewire.admin.collection.table')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
