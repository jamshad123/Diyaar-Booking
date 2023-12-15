<?php use App\Models\Rentout; ?>
<div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-md-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('agent_id','Agent',['class'=>'form-label']) }}
                        {{ Form::select('agent_id',[],'',['class'=>'form-control table_change select2-agent_id','id'=>'agent_id']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('room_id','Room',['class'=>'form-label']) }}
                        {{ Form::select('room_id',[],'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'room_id']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('type','Type',['class'=>'form-label']) }}
                        {{ Form::select('type',$types,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'type']) }}
                    </div>
                    <div class="mb-3 col-md-3" @if($status) hidden @endif>
                        {{ Form::label('status','Status',['class'=>'form-label']) }}
                        {{ Form::select('status',$statuses,$status,['wire:model'=>'status','class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'status']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('customer_id','Customer',['class'=>'form-label']) }}
                        {{ Form::select('customer_id',[],'',['class'=>'form-control table_change select2-customer_id','placeholder'=>'All','id'=>'customer_id']) }}
                    </div>
                </div>
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('based_on','Based On',['class'=>'form-label']) }}
                        {{ Form::select('based_on',['check_in_date'=>'Check in Date','check_out_date'=>'Check out Date'],'start_date',['class'=>'form-control table_change select2_class','id'=>'based_on']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('start_date','Start Date',['class'=>'form-label']) }}
                        {{ Form::date('start_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'start_date']) }}
                    </div>
                    <div class="mb-3 col-md-3">
                        {{ Form::label('end_date','Start Date',['class'=>'form-label']) }}
                        {{ Form::date('end_date','',['class'=>'form-control table_change','placeholder'=>'All','id'=>'end_date']) }}
                    </div>
                    <div class="mb-3 col-md-3" @if($flag==Rentout::Approved) hidden @endif>
                        {{ Form::label('flag','Flag',['class'=>'form-label']) }}
                        {{ Form::select('flag',[''=>'All']+$flags,$this->flag,['class'=>'form-control select2_class table_change','id'=>'flag']) }}
                    </div>
                    <div class="mb-3 col-md-3" style="padding-left: 80px;"> <br>
                        <button type="button" class="btn btn-primary" id="FetchButton" name="button">Fetch</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            {!! $htmlBuilder->table([
                'class' => "table table-bordered table-striped",
                'id' => 'list_table',
            ], true) !!}
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
            $("#room_id").select2({
                placeholder: "Select Room",
                width: '100%',
                ajax: {
                    url: '{{ route("Building::Room::GetList") }}',
                    dataType: 'json',
                    method: 'post',
                    delay: 250,
                    data: function (data) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search_tag: data.term,
                            building_id: $('#master_building_id').val(),
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.items, function (obj) { return { id: obj.id, text: obj.name }; }),
                            pagination: { more: (params.page * 30) < data.total_count }
                        };
                    },
                    cache: true
                },
            });
        });
    </script>
    @stop
</div>

<style>
#list_table{
    /* border: 1px solid #140c0c !important; */
}
#list_table th{
   padding-left: 15px !important;
   background-color: #d9dee3;
}


</style>