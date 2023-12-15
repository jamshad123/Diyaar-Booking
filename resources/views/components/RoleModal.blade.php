<div class="modal fade" id="RoleModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-xl modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content p-3 p-md-5">
      @livewire('admin.roles.create')
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
  window.addEventListener('CloseRoleModal', event => {
    $("#RoleModal").modal("hide");
  });
  window.addEventListener('OpenRoleModal', event => {
    $("#RoleModal").modal("show");
  });
</script>
@stop