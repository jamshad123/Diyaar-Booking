<?php use App\Models\User; ?>
<div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <div class="user-info text-center">
                        <h4 class="mb-2">{{ $User->name }}</h4>
                        <span class="badge bg-label-secondary"></span>
                    </div>
                </div>
            </div>
            <h5 class="pb-2 border-bottom mb-4">Details</h5>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <span class="fw-bold me-2">Email:</span>
                        <span>{{ $User->email }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-bold me-2">Name:</span>
                        <span>{{ $User->name }}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-center pt-3">
                    <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal">Edit</a>
                    @if($User->flag==User::Active)
                    <a href="javascript:;" class="btn btn-label-danger" id='flag-change-user'>Suspended</a>
                    @else
                    <a href="javascript:;" class="btn btn-label-success" id='flag-change-user'>Activate</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
        const suspendUser = document.querySelector('#flag-change-user');
        if (suspendUser) {
            suspendUser.onclick = function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This is to enable / disable user access to the site",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change user Flag!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-2',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        window.livewire.emit('FlagChange');
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'Cancelled Suspension :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            };
        }
    </script>
    @stop
</div>