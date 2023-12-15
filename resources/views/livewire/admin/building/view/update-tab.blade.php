<div>
    <div class="card mb-4">
        <h5 class="card-header">Building Details</h5>
        <hr class="my-0" />
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="mb-3 col-md-12">
                        {{ Form::label('name','Name *',['class'=>'form-label']) }}
                        {{ Form::text('name','',['wire:model'=>'buildings.name','class'=>'form-control','placeholder'=>'Please Enter Name']) }}
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    @if(\Permissions::Allow('Building.Delete'))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Delete Account</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete this building?</h6>
                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                    </div>
                    <form wire:submit.prevent="delete">
                        <button type="submit" class="btn btn-danger deactivate-account">Delete Building</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>