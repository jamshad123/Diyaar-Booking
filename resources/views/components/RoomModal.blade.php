<div class="modal fade" id="RoomModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        @livewire('admin.room.create',[ 'building_id'=> session('building_id') ])
    </div>
</div>
@section('script')
@parent
@stop
