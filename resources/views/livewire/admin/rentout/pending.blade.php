<?php use App\Models\Rentout; ?>
<div>
    <div class="card mb-2">
        <div class="card-header sticky-element d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
            <h5 class="card-title mb-sm-0"> </h5>
            <div class="action-btns">
                @if(!$rentout->checkout)
                @if(\Permissions::Allow('BookedPending.Approve'))
                @if($rentout['status']!=Rentout::Booked)
                <button type="button" class="btn btn-primary" wire:click="statusChange('{{ Rentout::Approved }}')"> Approve </button> &nbsp; &nbsp; &nbsp; &nbsp;
                @endif
                @if($rentout['status']!=Rentout::Rejected)
                <button type="button" class="btn btn-warning" wire:click="statusChange('{{ Rentout::Rejected }}')"> Reject </button> &nbsp; &nbsp; &nbsp; &nbsp;
                @endif
                @endif
                @endif
                <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingContractPrint',$rentout['id']) }}"> Booking Contract Print </a>&nbsp; &nbsp; &nbsp; &nbsp;
                <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingSummaryPrint',$rentout['id']) }}"> Booking Summary Print </a>
            </div>
        </div>
    </div>
</div>