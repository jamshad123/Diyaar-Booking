<div class="modal fade" id="RoomPriceModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-sm">
        @livewire('admin.room.price')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
window.addEventListener('OpenRoomPriceModal', event => {
    $('#RoomPriceModal').modal('show');
});
window.addEventListener('CloseRoomPriceModal', event => {
    $('#RoomPriceModal').modal('hide');
});
</script>
@stop
