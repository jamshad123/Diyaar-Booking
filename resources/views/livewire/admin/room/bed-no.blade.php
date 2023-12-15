<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Room Bed No Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('no_of_beds','No Of Beds *',['class'=>'form-label']) }}
                    {{ Form::number('no_of_beds','',['wire:model'=>'no_of_beds','class'=>'form-control number','placeholder'=>'Please Enter Room(s) No Of Beds']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
