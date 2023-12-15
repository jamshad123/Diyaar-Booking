<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="BuildingCreateTitle">User Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @if($this->getErrorBag()->count())
                    <ol>
                        <?php foreach ($this->getErrorBag()->toArray() as $key => $value): ?>
                        <li style="color:red">* {{ $value[0] }}</li>
                        <?php endforeach; ?>
                    </ol>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('name','Name *',['class'=>'form-label']) }}
                    {{ Form::text('name','',['wire:model'=>'users.name','class'=>'form-control','placeholder'=>'Please Enter Name','required']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('email','Email *',['class'=>'form-label']) }}
                    {{ Form::email('email','',['wire:model'=>'users.email','class'=>'form-control','placeholder'=>'Please Enter Email','required']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('password','Password *',['class'=>'form-label']) }}
                    {{ Form::password('password',['wire:model'=>'users.password','class'=>'form-control','placeholder'=>'Please Enter Password','required']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('password_confirmation','Confirm Password *',['class'=>'form-label']) }}
                    {{ Form::password('password_confirmation',['wire:model'=>'users.password_confirmation','class'=>'form-control','placeholder'=>'Please Confirm Password','required']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>