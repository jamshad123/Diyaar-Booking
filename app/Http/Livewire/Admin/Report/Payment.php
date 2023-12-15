<?php

namespace App\Http\Livewire\Admin\Report;

use App\Models\User;
use App\Models\Views\JournalView;
use Illuminate\Http\Request;
use Livewire\Component;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Payment extends Component
{
    public function mount()
    {
        $this->users = User::pluck('name', 'id')->toArray();
        $this->from_date = date('d-m-Y 0:0:0');
        $this->to_date = date('d-m-Y H:i');
        $this->paymentMode = paymentModeOptions();
    }

    public function render(Builder $htmlBuilder)
    {
        $Columns[] = Column::make('created_at')->searchable(true)->visible(true)->title('Date');
        $Columns[] = Column::make('created_by')->searchable(true)->visible(true)->title('User');
        $Columns[] = Column::make('model')->searchable(true)->visible(true)->title('Model');
        $Columns[] = Column::make('payment_mode')->searchable(true)->visible(true)->title('Payment Mode');
        $Columns[] = Column::make('amount')->searchable(true)->visible(true)->className('text-end')->title('Amount');
        $Columns[] = Column::make('reason')->searchable(true)->visible(true)->title('Reason');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('report::payment::datatable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token       = "'.csrf_token().'";
                d.user_id      = $("#user_id").val();
                d.from_date    = $("#from_date").val();
                d.to_date      = $("#to_date").val();
                d.payment_mode = $("#payment_mode").val();
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
                column++; $(n.column(column).footer()).html("<h6><b>"+o.amount+"</b></h6>");
            }',
        ]);

        return view('livewire.admin.report.payment')
        ->with('htmlBuilder', $htmlBuilder);
    }

    public function tableData(Request $request)
    {
        $data = $request->all();
        $datas = new JournalView;
        $datas = $datas->when($data['from_date'] ?? '', function ($q, $value) {
            return $q->where('created_at', '>', date('Y-m-d H:i:s', strtotime($value)));
        });
        $datas = $datas->when($data['to_date'] ?? '', function ($q, $value) {
            return $q->where('created_at', '<', date('Y-m-d H:i:s', strtotime($value)));
        });
        $datas = $datas->when($data['user_id'] ?? '', function ($q, $value) {
            return $q->where('created_by', $value);
        });
        $datas = $datas->when($data['payment_mode'] ?? '', function ($q, $value) {
            return $q->where('payment_mode', $value);
        });
        $amount = $datas->sum('amount');

        return Datatables::of($datas)
        ->editColumn('created_by', function ($value) {
            return "<a href='".route('User::View', $value->created_by)."'>".$value->user->name.'</a>';
        })
        ->editColumn('created_at', function ($value) {
            return systemDateTime($value->created_at);
        })
        ->editColumn('amount', function ($value) {
            return currency($value->amount);
        })
        ->addIndexColumn()
        ->rawColumns(['created_by'])
        ->with('amount', currency($amount))
        ->make(true);
    }
}
