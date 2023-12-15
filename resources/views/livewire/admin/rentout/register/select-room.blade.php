<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="RoomSelectionTitle">Room Selection Modal</h5>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-8">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            {{ Form::label('based_on','Based On',['class'=>'form-label']) }}
                            {{ Form::select('based_on',$BasedOn,'',['wire:model'=>'based_on','class'=>'form-control select_table_change','id'=>"select_modal_no_of_beds"]) }}
                        </div>
                        <div class="col-md-4" @if($based_on!="no_of_beds" ) hidden @endif>
                            {{ Form::label('no_of_beds','No Of Beds',['class'=>'form-label']) }}
                            {{ Form::number('no_of_beds','',['wire:model'=>'no_of_beds','min'=>1,'class'=>'form-control select_table_change','id'=>"select_modal_no_of_beds"]) }}
                        </div>
                        <div class="col-md-4" @if($based_on!="no_of_rooms" ) hidden @endif>
                            {{ Form::label('no_of_rooms','No Of Rooms',['class'=>'form-label']) }}
                            {{ Form::number('no_of_rooms','',['wire:model'=>'no_of_rooms','min'=>1,'class'=>'form-control select_table_change','id'=>"select_modal_no_of_rooms"]) }}
                        </div>
                        <div class="col-md-4"> <br>
                            <button type="button" class="btn btn-primary" wire:click="Check">Check Rooms</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6" wire:ignore>
                            {{ Form::label('type','Type',['class'=>'form-label']) }}
                            {{ Form::select('type',[''=>'All']+$types,'',['wire:model'=>'type','class'=>'form-control select2_class select_table_change','id'=>"select_modal_type"]) }}
                        </div>
                        <div class="col-md-6" wire:ignore>
                            {{ Form::label('floor','Floor',['class'=>'form-label']) }}
                            {{ Form::select('floor',[''=>'All']+$floors,'',['wire:model'=>'floor','class'=>'form-control select2_class select_table_change','id'=>"select_modal_floor"]) }}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <table class="table table-sm table-bordered table-hover table-sm table-striped">
                        <tr>
                            <th>Available Rooms</th>
                            <td class="text-end">{{ $available_no_of_rooms }}</td>
                        </tr>
                        <tr>
                            <th>Available No of Beds</th>
                            <td class="text-end">{{ $available_no_of_beds }}</td>
                        </tr>
                        <tr>
                            <th>Selected Rooms</th>
                            <td class="text-end">{{ $selected_no_of_rooms }}</td>
                        </tr>
                        <tr>
                            <th>Selected No of Beds</th>
                            <td class="text-end">{{ $selected_no_of_beds }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="table-responsive" wire:ignore>
                        <h3>Available Rooms</h3>
                        {!! $htmlBuilder->table(['class'=>"table table-sm table-bordered table-hover",'style'=>'width:100%','id'=>'AvailableRoomDataTable']) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <h3>Selected Rooms</h3>
                    <div class="table-responsive text-nowrap" wire:ignore>
                        <table class="table table-sm table-bordered table-hover" id="SelectedTableDataTable">
                            <thead>
                                <tr>
                                    <th class="text-end" class="selectAllRender">#</th>
                                    <th class="text-end">Room No</th>
                                    <th>Type</th>
                                    <th>Floor</th>
                                    <th>No Of Beds</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
        </div>
    </form>
    @section('script')
    @parent
    {!! $htmlBuilder->scripts() !!}
    <script type="text/javascript">
        $(document).ready(function () {
            AvailableRoomDataTable = window.LaravelDataTables['AvailableRoomDataTable'];
            window.addEventListener('SelectModelTableDraw', event => {
                AvailableRoomDataTable.draw();
                SelectedTableDataTable.draw();
            });
            $('.select_table_change').change(function () {
                AvailableRoomDataTable.draw();
                SelectedTableDataTable.draw();
            });
            $('#select_modal_type').on('select2:select change', function (e) {
                @this.set('type', $(this).val());
            });
            $('#select_modal_floor').on('select2:select change', function (e) {
                @this.set('floor', $(this).val());
            });
        });
    </script>
    @stop
</div>