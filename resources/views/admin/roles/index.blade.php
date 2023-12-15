@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2">Roles List</h4>
    <p>A role provided access to predefined menus and features so that depending on <br> assigned role an administrator can have access to what user needs.</p>
    @livewire('admin.roles.table')
</div>
@component('components.RoleModal') @endcomponent
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection