@extends('admin.layout.app')
@section('title', 'Check in')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.rentout.view',['rentout_id'=>$id])
    @livewire('admin.rentout.checkin',['rentout_id'=>$id])
</div>
@endsection
@section('style')
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
