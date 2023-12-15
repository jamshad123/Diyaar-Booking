@extends('admin.layout.app')
@section('title', 'Settings')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @livewire('admin.settings.general')
</div>
@endsection
@section('vendor-style')
@endsection
@section('vendor-script')
@endsection
