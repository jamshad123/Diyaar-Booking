<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('usage_level','Usage Level',['class'=>'form-label']) }}
                        {{ Form::select('usage_level',[''=>'All']+['not_used'=>'Not Used','used'=>'Used'],'not_used',['class'=>'select2_class table_change','id'=>'usage_level']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('created_by','Created By',['class'=>'form-label']) }}
                        {{ Form::select('created_by',[''=>'All']+$users,'',['class'=>'select2_class table_change','id'=>'created_by']) }}
                    </div>
                    <div class="mb-3 col-md-2" hidden>
                        {{ Form::label('used_by','Used By',['class'=>'form-label']) }}
                        {{ Form::select('used_by',[''=>'All']+$users,'',['class'=>'select2_class table_change','id'=>'used_by']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            {!! $htmlBuilder->table(['class'=>"table border-top"],true) !!}
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