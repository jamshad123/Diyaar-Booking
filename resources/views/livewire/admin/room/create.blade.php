<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="BuildingCreateTitle">Room Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @error('rooms.building_id') <span style="color:red" class="error"> * {{ $message }} <br> </span> @enderror
                    @error('rooms.room_no') <span style="color:red" class="error"> * {{ $message }} <br> </span> @enderror
                    @error('rooms.floor') <span style="color:red" class="error"> * {{ $message }} <br> </span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('room_no','Room No *',['class'=>'form-label']) }}
                    {{ Form::number('room_no','',['wire:model'=>'rooms.room_no','class'=>'form-control number','placeholder'=>'Please Enter Room No']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('floor','Floor *',['class'=>'form-label']) }}
                    {{ Form::text('floor','',['wire:model'=>'rooms.floor','class'=>'form-control','placeholder'=>'Please Enter Floor']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('type','Type *',['class'=>'form-label']) }}
                    {{ Form::select('type',$types,'',['wire:model'=>'rooms.type','class'=>'form-control','placeholder'=>'Please Select Type','id'=>'modal_type']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('amount','Amount *',['class'=>'form-label']) }}
                    {{ Form::number('amount','',['wire:model'=>'rooms.amount','class'=>'form-control number','placeholder'=>'Please Enter Amount']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('hygiene_status','Hygiene Status *',['class'=>'form-label']) }}
                    {{ Form::select('hygiene_status',$hygiene_statuses,'',['wire:model'=>'rooms.hygiene_status','class'=>'form-control','placeholder'=>'Please Select Hygiene Status','id'=>'modal_hygiene_status']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('status','Status *',['class'=>'form-label']) }}
                    {{ Form::select('status',$statuses,'',['wire:model'=>'rooms.status','class'=>'form-control','placeholder'=>'Please Select Status','id'=>'modal_status']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('capacity','Capacity',['class'=>'form-label']) }}
                    {{ Form::number('capacity','',['wire:model'=>'rooms.capacity','class'=>'form-control','placeholder'=>'Please Enter Capacity']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('extra_capacity','Extra Capacity',['class'=>'form-label']) }}
                    {{ Form::number('extra_capacity','',['wire:model'=>'rooms.extra_capacity','class'=>'form-control','placeholder'=>'Please Enter extra capacity']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('no_of_beds','No Of Beds',['class'=>'form-label']) }}
                    {{ Form::number('no_of_beds','',['wire:model'=>'rooms.no_of_beds','class'=>'form-control','placeholder'=>'Please Enter no of beds']) }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{ Form::label('description','Description',['class'=>'form-label']) }}
                    {{ Form::textarea('description','',['wire:model'=>'rooms.description','class'=>'form-control','placeholder'=>'Please Enter rooms Description','rows'=>3]) }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{ Form::label('reserve_condition','Reserve Condition',['class'=>'form-label']) }}
                    {{ Form::textarea('reserve_condition','',['wire:model'=>'rooms.reserve_condition','class'=>'form-control','placeholder'=>'Please Enter rooms Description','rows'=>3]) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <label class="switch switch-lg">
                <input type="checkbox" wire:model="closeFlag" class="switch-input" checked />
                <span class="switch-toggle-slider">
                    <span class="switch-on"> <i class="bx bx-check"></i> </span>
                    <span class="switch-off"> <i class="bx bx-x"></i> </span>
                </span>
                <span class="switch-label">Close window on save</span>
            </label>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    @section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        window.addEventListener('CloseRoomModal', event => {
            $("#RoomModal").modal("hide");
        });
        // $('#modal_type').on('select2:select change', function(e) {
        // @this.set('rooms.type', $(this).val());
        // });
    });
    </script>
    @stop
</div>
