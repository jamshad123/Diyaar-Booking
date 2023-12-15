<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('customer_type','Type',['class'=>'form-label']) }}
                        {{ Form::select('customer_type',[''=>'All']+customerTypeOptions(),'',['class'=>'select2_class table_change','id'=>'customer_type']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('gender','Gender',['class'=>'form-label']) }}
                        {{ Form::select('gender',[''=>'All']+genderOptions(),'',['class'=>'select2_class table_change','id'=>'gender']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('document_type','Document Type',['class'=>'form-label']) }}
                        {{ Form::select('document_type',[''=>'All']+documentTypeOptions(),'',['class'=>'select2_class table_change','id'=>'document_type']) }}
                    </div>
                    <div class="mb-3 col-md-2">
                        {{ Form::label('country','Country',['class'=>'form-label']) }}
                        {{ Form::select('country',[''=>'All']+Countries::getList('en'),'',['class'=>'select2_class table_change','id'=>'country']) }}
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
    $(document).ready(function() {
        dataTable = window.LaravelDataTables.dataTableBuilder;
        window.addEventListener('TableDraw', event => {
            dataTable.draw();
        });
        $('.table_change').change(function(){
            dataTable.draw();
        });
        $(document).on('click','.edit',function(){
            window.livewire.emit("EditAgent",$(this).attr('table_id'));
            $("#AgentModal").modal("show");
        });
    });
    </script>
    @stop
</div>
