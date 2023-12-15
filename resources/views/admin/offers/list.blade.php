@extends('admin.layout.app')
@section('title', 'Offers')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2">Offers List</h4>
    @livewire('admin.offer.table')
</div>
@component('components.OfferModal') @endcomponent
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
@endsection
@section('vendor-script')
@include('components.datatableJsFiles')
@endsection