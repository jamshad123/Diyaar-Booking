<?php use App\Models\Room; ?>
<?php use App\Models\Rentout; ?>
@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row mb-3">
        <div class="col-md-12">
            <ul class="nav nav-pills nav- card-header-pills" role="tablist">
                @if(\Permissions::Allow('Room Status.Grid View'))
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-grid-view" aria-controls="navs-grid-view" aria-selected="true">
                        Grid View
                    </button>
                </li>
                @endif
                @if(\Permissions::Allow('Room Status.Table View'))
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link @if(!\Permissions::Allow('Room Status.Grid View')) active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-table-view" aria-controls="navs-table-view" aria-selected="false" tabindex="-1">
                        Table View
                    </button>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="mb-3 col-md-2">
                    {{ Form::label('floor','Floor *',['class'=>'form-label']) }}
                    {{ Form::select('floor',$floors??[],'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'floor']) }}
                </div>
                <div class="mb-3 col-md-2">
                    {{ Form::label('type','Type *',['class'=>'form-label']) }}
                    {{ Form::select('type',Room::typeOptions(),'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'type']) }}
                </div>
                <div class="mb-3 col-md-2">
                    {{ Form::label('hygiene_status','Hygiene Status *',['class'=>'form-label']) }}
                    {{ Form::select('hygiene_status',Room::hygieneStatusOptions(),'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'hygiene_status']) }}
                </div>
                <div class="mb-3 col-md-2">
                    {{ Form::label('booking_status','Booking Status *',['class'=>'form-label']) }}
                    {{ Form::select('booking_status',Rentout::statusOptions(),'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'booking_status']) }}
                </div>
                <div class="mb-3 col-md-2">
                    {{ Form::label('status','Room Status *',['class'=>'form-label']) }}
                    {{ Form::select('status',Room::statusOptions(),'',['class'=>'form-control table_change select2_class','placeholder'=>'All','id'=>'status']) }}
                </div>
                <div class="mb-3 col-md-1"> <br>
                    <button type="button" id="FetchButton" class="btn btn-success" name="button">Fetch</button>
                </div>
            </div>
            <div class="row">
                @if(\Permissions::Allow('Room.Hygiene Status'))
                <div class="mb-3 col-md-2"> <br>
                    <button type="button" id="MakeitClean" class="btn btn-sm btn-primary" name="button">Make it Clean</button>
                </div>
                <div class="mb-3 col-md-2"> <br>
                    <button type="button" id="MakeitDirty" class="btn btn-sm btn-danger" name="button">Make it Dirty</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="tab-content pt-0">
                @if(\Permissions::Allow('Room Status.Grid View'))
                <div class="tab-pane fade show active" id="navs-grid-view" role="tabpanel">
                    <div class="row">
                        <div class="mb-3 col-md-2">
                            {{ Form::label('date','Date *',['class'=>'form-label']) }}
                            {{ Form::date('date',date('Y-m-d'),['class'=>'form-control table_change','id'=>'date']) }}
                        </div>
                        @livewire('admin.room.status')
                    </div>
                </div>
                @endif
                @if(\Permissions::Allow('Room Status.Table View'))
                <div class="tab-pane fade @if(!\Permissions::Allow('Room Status.Grid View')) show active @endif" id="navs-table-view" role="tabpanel">
                    <div class="row">
                        <div class="mb-3 col-md-2">
                            {{ Form::label('from_date','From Date *',['class'=>'form-label']) }}
                            {{ Form::date('from_date',date('Y-m-d',strtotime('-6 days')),['class'=>'form-control table_change','id'=>'from_date']) }}
                        </div>
                        <div class="mb-3 col-md-2">
                            {{ Form::label('to_date','To Date *',['class'=>'form-label']) }}
                            {{ Form::date('to_date',date('Y-m-d'),['class'=>'form-control table_change','id'=>'to_date']) }}
                        </div>
                        <div class="mb-3 col-md-1" hidden> <br>
                            <button type="button" id="PrintButton" class="btn btn-success" name="button">Print</button>
                        </div>
                    </div>
                    <div class="table-responsive text-start text-nowrap">
                        @livewire('admin.room.table-status')
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@component('components.RoomViewModal') @endcomponent
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
<script type="text/javascript">
    $('#FetchButton').on('click', function (e) {
        window.livewire.emit("Fetch");
    });
    $('#PrintButton').on('click', function (e) {
        window.livewire.emit("Print");
    });
    $('#MakeitClean').on('click', function (e) {
        window.livewire.emit("MakeitClean");
    });
    $('#MakeitDirty').on('click', function (e) {
        window.livewire.emit("MakeitDirty");
    });
</script>
@endsection