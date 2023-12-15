<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class Plan extends Component
{
    public $building_id;

    public $room_count;

    public $date;

    protected $listeners = [
        'Print',
    ];

    public function mount()
    {
        $this->building_id = session('building_id');
        $this->room_count = Room::buildingId($this->building_id)->select(DB::raw('count(floor) as room_count'))->groupBy('floor')->orderByRaw('count(floor) DESC')->value('room_count');
        $this->date = date('Y-m-d');
    }

    public function Print()
    {
      return redirect(route('Building::Room::Plan::Print', $this->date));
    }

    public function render(Builder $htmlBuilder)
    {
        $Columns[] = Column::make('floor')->width('5%')->orderable(false)->searchable(true)->visible(true)->title('Floor / Rooms');
        for ($i = 0; $i < $this->room_count; $i++) {
            $Columns[] = Column::make($i)->orderable(false)->searchable(true)->visible(true)->className('text-center')->title($i + 1);
        }
        $Columns[] = Column::make('total_no_of_beds')->width('5%')->orderable(false)->searchable(true)->visible(true)->title('Total No of beds');
        $Columns[] = Column::make('available_no_of_beds')->width('5%')->orderable(false)->searchable(true)->visible(true)->title('Available No of beds');
        $htmlBuilder = $htmlBuilder->columns($Columns);
        $htmlBuilder->ajax([
            'url' => route('Building::Room::Plan::DataTable'),
            'type' => 'post',
            'data' => 'function(d){
                d._token      = "'.csrf_token().'";
                d.date        = $("#date").val();
                d.building_id = "'.$this->building_id.'";
                d.room_count  = "'.$this->room_count.'";
            }',
        ]);
        $htmlBuilder->parameters([
            'lengthMenu' => [[10, 50, 100, '-1'], [10, 50, 100, 'All']],
            'searching' => false,
            'autoWidth' => true,
            'scrollX' => true,
            'scrollCollapse' => true,
            'fixedColumns' => [
                'left' => 1,
                'right' => 2,
            ],
        ]);
        $htmlBuilder->parameters([
            'footerCallback' => 'function(t,o,a,l,m){
                var n = this.api(),o=RoomStatusDataTable.ajax.json();
                var column = 0;
                column++; $(n.column(column).footer()).html(
                    "<h6><b>VACANT:"+o.vacant+"</b></h6>"+
                    "<h6><b>OCCUPIED:"+o.occupied+"</b></h6>"+
                    "<h6><b>Checkout:"+o.checkout+"</b></h6>"+
                    "<h6><b>Total No Of Beds:"+o.total_no_of_beds+"</b></h6>"+
                    "<h6><b>Available No Of Beds:"+o.available_beds+"</b></h6>"
                );
            }',
        ]);

        return view('livewire.admin.room.plan')->with('htmlBuilder', $htmlBuilder);
    }
}
