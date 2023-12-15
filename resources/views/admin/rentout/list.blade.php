@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.rentout.table',['status'=>$status,'flag'=>$flag])
</div>
@component('components.CustomerModal') @endcomponent
@component('components.AgentModal') @endcomponent
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('vendor-script')
@include('components.agentSelect2')
@include('components.customerSelect2')
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@include('components.datatableJsFiles')
@endsection