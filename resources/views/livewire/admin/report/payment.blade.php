<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('from_date','From Date',['class'=>'form-label']) }}
                        {{ Form::text('from_date','',['wire:model'=>'from_date','class'=>'form-control','id'=>'from_date']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('to_date','To Date',['class'=>'form-label']) }}
                        {{Form::text('to_date','',['wire:model'=>'to_date','class'=>'form-control','id'=>'to_date']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('user_id','User',['class'=>'form-label']) }}
                        {{ Form::select('user_id',[''=>'All']+$users,'',['class'=>'select2_class table_change','id'=>'user_id']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('payment_mode','Payment Mode',['class'=>'form-label']) }}
                        {{ Form::select('payment_mode',[''=>'All']+$paymentMode,'',['class'=>'select2_class table_change','id'=>'payment_mode']) }}
                    </div>
                    <div class="mb-3 col-md-2"> <br>
                        <button class="btn btn-primary" id="FetchButton">Fetch</button>
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
            from_date = $('#from_date').flatpickr({
                enableTime: true,
                dateFormat: 'd-m-Y H:i',
            });
            to_date = $('#to_date').flatpickr({
                enableTime: true,
                dateFormat: 'd-m-Y H:i',
            });
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