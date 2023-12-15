@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.building.table')
</div>
<div class="modal fade" id="BuildingCreateModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        @livewire('admin.building.create')
    </div>
</div>
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
