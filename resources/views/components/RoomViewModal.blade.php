<div class="modal fade" id="RoomViewModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        @livewire('admin.room.view-modal')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
window.addEventListener('OpenRoomViewModal', event => {
    $('#RoomViewModal').modal('show')
});
window.addEventListener('CloseRoomViewModal', event => {
    $("#RoomViewModal").modal("hide");
});
</script>
@stop
