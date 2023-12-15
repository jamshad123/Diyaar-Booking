@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User / View /</span> Account</h4>
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                @livewire('admin.user.view',['user_id'=>$id])
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-Security" aria-controls="navs-Security" aria-selected="true"> <i class="bx bx-lock-alt me-1"></i> Security </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-roles" aria-controls="navs-roles" aria-selected="false" tabindex="-1"> Roles </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-buildings" aria-controls="navs-buildings" aria-selected="false" tabindex="-1"> Building </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-Security" role="tabpanel">
                            @livewire('admin.user.password-change',['user_id'=>$id])
                        </div>
                        <div class="tab-pane fade" id="navs-roles" role="tabpanel">
                            @livewire('admin.user.roles',['user_id'=>$id])
                        </div>
                        <div class="tab-pane fade" id="navs-buildings" role="tabpanel">
                            @livewire('admin.user.enabled-building',['user_id'=>$id])
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <h5 class="card-header">Recent Devices</h5>
                     @livewire('admin.user.visit-history',['user_id'=>$id])
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Edit User Information</h3>
                        <p>Updating user details will receive a privacy audit.</p>
                    </div>
                    @livewire('admin.user.edit',['user_id'=>$id])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection