@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.room.plan')
</div>
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
<style media="screen">
.nowrap {
    white-space: nowrap;
}
</style>
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
