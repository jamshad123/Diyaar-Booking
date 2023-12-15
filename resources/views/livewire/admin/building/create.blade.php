<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="BuildingCreateTitle">Building Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @error('buildings.name') <span style="color:red" class="error"> * {{ $message }} <br> </span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('name','Name *',['class'=>'form-label']) }}
                    {{ Form::text('name','',['wire:model'=>'buildings.name','class'=>'form-control','placeholder'=>'Please Enter Name']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>