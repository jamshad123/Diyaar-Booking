<div class="modal fade" id="SelectRoomModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        @livewire('admin.rentout.register.select-room')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
window.addEventListener('OpenSelectRoomModal', event => {
    $('#SelectRoomModal').modal('show');
});
window.addEventListener('CloseSelectRoomModal', event => {
    $('#SelectRoomModal').modal('hide');
});
</script>
@stop
