@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.building.view',['id'=>$id])
</div>
@component('components.RoomModal',['building_id'=>$id]) @endcomponent
@endsection
@section('style')
<style media="screen">
.nav-align-top > .tab-content, .nav-align-right > .tab-content, .nav-align-bottom > .tab-content, .nav-align-left > .tab-content{
    background:#f4f5fb !important;
}
</style>
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
