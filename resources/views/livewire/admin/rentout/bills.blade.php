<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('start_date','Date',['class'=>'form-label']) }}
                        {{ Form::date('start_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'start_date']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('end_date','Start Date',['class'=>'form-label']) }}
                        {{ Form::date('end_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'end_date']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('customer_id','Customer',['class'=>'form-label']) }}
                        {{ Form::select('customer_id',[],'',['class'=>'form-control table_change select2-customer_id','placeholder'=>'All','id'=>'customer_id']) }}
                    </div>
                    <div class="mb-3 col-md-3"> <br>
                        <button type="button" class="btn btn-primary" id="FetchButton" name="button">Fetch</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            {!! $htmlBuilder->table(['class'=>"table border-top  "],true) !!}
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
            $('#FetchButton').click(function () {
                dataTable.draw();
            });
        });
    </script>
    @stop
</div>