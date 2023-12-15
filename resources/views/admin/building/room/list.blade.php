@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.room.table')
</div>
@component('components.RoomModal') @endcomponent
@component('components.RoomPriceModal') @endcomponent
@component('components.RoomBedNoModal') @endcomponent
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
