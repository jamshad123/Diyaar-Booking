<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card status-card" id="type">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Type</h5>
                        </div>
                        <div class="card-body row gap-md-0 "  style="flex: 0;">
                            <?php $total = array_sum(array_column($TypeGroupCount,'count')); ?>
                            <?php foreach ($TypeGroupCount as $key => $value): ?>
                                <?php $width = $value['count']/$total*100; ?>
                                <div class="col-md-12 d-flex flex-column justify-content-between">
                                    <div class="progress-wrapper">
                                        <div class="mb-1">
                                            <small class="text-muted">{{ $value['name'] }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-2" style="height: 8px">
                                                    <div class="progress-bar bg-info" style="width: {{ $width }}%" role="progressbar" aria-valuenow="{{ $width }}" aria-valuemin="0" aria-valuemax="{{ $total }}"></div>
                                                </div>
                                                <small class="text-muted">{{ $value['count'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card status-card" id="status">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Status</h5>
                        </div>
                        <div class="card-body row gap-md-0 " style="flex: 0;">
                            <?php $total = array_sum(array_column($StatusGroupCount,'count')); ?>
                            <?php foreach ($StatusGroupCount as $key => $value): ?>
                                <?php $width = $value['count']/$total*100; ?>
                                <div class="col-md-12 d-flex flex-column justify-content-between">
                                    <div class="progress-wrapper">
                                        <div class="mb-1">
                                            <small class="text-muted">{{ $value['name'] }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-2" style="height: 8px">
                                                    <div class="progress-bar bg-primary" style="width: {{ $width }}%" role="progressbar" aria-valuenow="{{ $width }}" aria-valuemin="0" aria-valuemax="{{ $total }}"></div>
                                                </div>
                                                <small class="text-muted">{{ $value['count'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card status-card" id="hygieneStatus">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Hygiene Status</h5>
                        </div>
                        <div class="card-body row gap-md-0 "  style="flex: 0;">
                            <?php $total = array_sum(array_column($HygieneStatusGroupCount,'count')); ?>
                            <?php foreach ($HygieneStatusGroupCount as $key => $value): ?>
                                <?php $width = $value['count']/$total*100; ?>
                                <div class="col-md-12 d-flex flex-column justify-content-between">
                                    <div class="progress-wrapper">
                                        <div class="mb-1">
                                            <small class="text-muted">{{ $value['name'] }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-2" style="height: 8px">
                                                    <div class="progress-bar bg-warning" style="width: {{ $width }}%" role="progressbar" aria-valuenow="{{ $width }}" aria-valuemin="0" aria-valuemax="{{ $total }}"></div>
                                                </div>
                                                <small class="text-muted">{{ $value['count'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card" id="tableFilter" style="display: none; position: fixed; top: 80px; right: 0; height: 80%; overflow-y: auto; width: 300px; z-index: 1000;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Filter</span>
                <button type="button" class="btn-close" aria-label="Close" id="closeFilterButton"></button>
            </div>
            <div class="card-body">
                <div class="row" wire:ignore>
                    <div class="mb-3 col-md-12">
                        {{ Form::label('building_id','Building *',['class'=>'form-label']) }}
                        {{ Form::select('building_id',$Building,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'building_id']) }}
                    </div>
                    <div class="mb-3 col-md-12">
                        {{ Form::label('floor','Floor *',['class'=>'form-label']) }}
                        {{ Form::select('floor',$floors,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'floor']) }}
                    </div>
                    <div class="mb-3 col-md-12">
                        {{ Form::label('type','Type *',['class'=>'form-label']) }}
                        {{ Form::select('type',$types,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'type']) }}
                    </div>
                    <div class="mb-3 col-md-12">
                        {{ Form::label('hygiene_status','Hygiene Status *',['class'=>'form-label']) }}
                        {{ Form::select('hygiene_status',$hygiene_statuses,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'hygiene_status']) }}
                    </div>
                    <div class="mb-3 col-md-12">
                        {{ Form::label('status','Status *',['class'=>'form-label']) }}
                        {{ Form::select('status',$statuses,'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'status']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive" wire:ignore>
                {!! $htmlBuilder->table(['class'=>"table border-top ",'style' => 'letter-spacing: 0px;']) !!}
            </div>
        </div>
    </div>
    @section('script')
    @parent
    {!! $htmlBuilder->scripts() !!}
    <script type="text/javascript">
    $(document).ready(function() {
        let maxHeight = 0;
        $('.status-card').each(function () {
            let currentHeight = $(this).height();
            if (currentHeight > maxHeight) {
                maxHeight = currentHeight;
            }
        });
        $('.status-card').height(maxHeight);
        document.getElementById('closeFilterButton').addEventListener('click', function () {
            $("#tableFilter").toggle();
        });
        dataTable = window.LaravelDataTables.dataTableBuilder;
        window.addEventListener('TableDraw', event => {
            dataTable.draw();
        });
        $(document).on('click','.room_edit',function(){
            window.livewire.emit("EditRoom",$(this).attr('table_id'));
            $("#RoomModal").modal("show");
        });
        $('.table_change').change(function() {
            dataTable.draw();
        });
    });
    </script>
    @stop
</div>
