<div>
    <p>Please Select Buildings</p>
    <div class="row">
        <div class="mb-3 col" wire:ignore>
            {{ Form::label('buildings','Buildings',['class'=>'form-label']) }}
            {{ Form::select('buildings',$buildingList,'',['wire:model'=>'user_buildings','class'=>'form-control select2_class','multiple','id'=>'user_buildings']) }}
        </div>
        <div class="mb-3 col-md-2"> <br>
            <button class="btn btn-success" wire:click="save">Save</button>
        </div>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('#user_buildings').change();
            $('#user_buildings').on('select2:select change', function (e) {
                @this.set('user_buildings', $(this).val());
            });
        });
    </script>
    @stop
</div>