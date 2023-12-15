<div>
    <p>Please Enable Required Roles</p>
    <div class="row">
        <div class="mb-3 col" wire:ignore>
            {{ Form::label('roles','Roles',['class'=>'form-label']) }}
            {{ Form::select('roles',$Roles,'',['wire:model'=>'user_roles','class'=>'form-control select2_class','multiple','id'=>'user_roles']) }}
        </div>
        <div class="mb-3 col-md-2"> <br>
            <button class="btn btn-success" wire:click="save">Save</button>
        </div>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('#user_roles').change();
            $('#user_roles').on('select2:select change', function (e) {
                @this.set('user_roles', $(this).val());
            });
        });
    </script>
    @stop
</div>