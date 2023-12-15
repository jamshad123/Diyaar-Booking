<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Rentout;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Bills extends Component
{
    protected $listeners = [
        'RentoutMultiDelete' => 'MultiDelete',
    ];

    public function mount($status = null)
    {
        $this->status = $status;
        $this->building_id = session('building_id');
        $this->statuses = Rentout::statusOptions();
        $this->types = Room::typeOptions();
    }

    public function MultiDelete($ids)
    {
        try {
            DB::beginTransaction();
            $Rentout = new Rentout;
            foreach ($ids as  $id) {
                $response = $Rentout->selfDelete($id);
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
        $Columns[] = Column::make('id')->name('checkouts.id')->searchable(true)->visible(true)->className('text-end')->title('#');
        $Columns[] = Column::make('created_at')->name('checkouts.created_at')->searchable(true)->visible(true)->title('Date');
        $Columns[] = Column::make('customer_id')->searchable(true)->visible(true)->title('customer Name');
        $Columns[] = Column::make('mobile')->searchable(true)->visible(true)->title('Mobile');
        $Columns[] = Column::make('total')->searchable(true)->visible(true)->className('text-end')->title('Total');
        $Columns[] = Column::make('tax')->searchable(true)->visible(true)->className('text-end')->title('Tax');
        $Columns[] = Column::make('special_discount_amount')->searchable(true)->visible(true)->className('text-end')->title('Discount');
        $Columns[] = Column::make('additional_charges')->searchable(true)->visible(true)->className('text-end')->title('Additional Amount');
        $Columns[] = Column::make('grand_total')->searchable(true)->visible(true)->className('text-end')->title('Grand Total');
        $Columns[] = Column::make('advance_amount')->searchable(true)->visible(true)->className('text-end')->title('Advance Amount');
        $Columns[] = Column::make('paid')->searchable(true)->visible(true)->className('text-end')->title('Paid');
        $Columns[] = Column::make('balance')->searchable(true)->visible(true)->className('text-end')->title('Balance');
        $Columns[] = Column::make('action')->searchable(true)->visible(true)->title('action');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Rentout::checkout::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token      = "'.csrf_token().'";
                d.building_id = "'.$this->building_id.'";
                d.start_date  = $("#start_date").val();
                d.end_date    = $("#end_date").val();
                d.customer_id = $("#customer_id").val();
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
        $htmlBuilder->parameters([
            'footerCallback' => 'function(t,o,a,l,m){
                var n=this.api(),o=dataTable.ajax.json();
                var column=3;
                column++; $(n.column(column).footer()).html("<h6><b>"+o.total+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.tax+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.special_discount_amount+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.additional_charges+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.grand_total+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.advance_amount+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.paid+"</b></h6>");
                column++; $(n.column(column).footer()).html("<h6><b>"+o.balance+"</b></h6>");
            }',
        ]);

        return view('livewire.admin.rentout.bills')
        ->with('htmlBuilder', $htmlBuilder);
    }
}
