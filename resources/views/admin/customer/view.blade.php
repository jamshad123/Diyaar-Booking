@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.customer.view',['id'=>$id])
</div>
@component('components.CustomerModal') @endcomponent
@endsection
@section('style')
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection
