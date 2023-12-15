<div>
    <form id="editUserForm" class="row g-3" wire:submit.prevent="save">
        <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserName">Name</label>
            <input type="text" id="modalEditUserName" wire:model="users.name" class="form-control" placeholder="John" />
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserEmail">Email</label>
            <input type="text" id="modalEditUserEmail" wire:model="users.email" class="form-control" placeholder="example@domain.com" />
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
        </div>
    </form>
    @section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        window.addEventListener('CloseUserEditModel', event => {
            $('#editUser').modal('hide');
        });
    });
    </script>
    @stop
</div>
