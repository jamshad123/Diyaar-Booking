<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Offer Table</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('based_on','Based On',['class'=>'form-label']) }}
                        {{ Form::select('based_on',['start_date'=>'Start Date','end_date'=>'End Date'],'start_date',['class'=>'form-control table_change select2_class','id'=>'based_on']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('from_date','From Date',['class'=>'form-label']) }}
                        {{ Form::date('from_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'from_date']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('to_date','To Date',['class'=>'form-label']) }}
                        {{ Form::date('to_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'to_date']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('status','Status',['class'=>'form-label']) }}
                        {{ Form::select('status',[''=>'All']+activeAndDisabled(),'Active',['class'=>'select2_class table_change','id'=>'status']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            {!! $htmlBuilder->table(['class'=>"table border-top "],true) !!}
        </div>
    </div>
    @section('script')
    @parent
    {!! $htmlBuilder->scripts() !!}
    <script type="text/javascript">
        $(document).ready(function () {
            dataTable = window.LaravelDataTables.dataTableBuilder;
            window.addEventListener('TableDraw', event => {
                dataTable.draw();
            });
            $('.table_change').change(function () {
                dataTable.draw();
            });
        });
    </script>
    @stop
</div>