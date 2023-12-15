<div class="modal fade" id="RoomBedNoModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-sm">
        @livewire('admin.room.bed-no')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
window.addEventListener('OpenRoomBedNoModal', event => {
    $('#RoomBedNoModal').modal('show');
});
window.addEventListener('CloseRoomBedNoModal', event => {
    $('#RoomBedNoModal').modal('hide');
});
</script>
@stop
