<div class="container-fluid hilighted">
    {{ Form::select('building_id',$buildings,session('building_id'),['wire:ignore','class'=>'form-control select2_class','id'=>'master_building_id']) }}
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('change', '#master_building_id', function () {
                @this.set('building_id', $(this).val());
            });
        });
    </script>
    @stop
    <style>
        .light-style .hilighted .select2-container--default .select2-selection {
            background-color: #e8e8ff;
            border: 1px solid #6a6cff;
        }
    </style>
</div>