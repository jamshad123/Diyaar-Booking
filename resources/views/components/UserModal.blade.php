<div class="modal fade" id="UserModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        @livewire('admin.user.page')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
window.addEventListener('ToggleUserModal', event => {
    $('#UserModal').modal('toggle')
});
</script>
@stop
