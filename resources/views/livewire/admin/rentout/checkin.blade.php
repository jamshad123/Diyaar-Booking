<?php use App\Models\Rentout; ?>
<div>
    <div class="card mb-2">
        <div class="card-body">
            @if(\Permissions::Allow('Booking.Security deposit'))
            <div class="text-light small fw-semibold">Security Deposite</div>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th wire:ignore width="50%">
                        {{ Form::label('security_deposit_payment_mode','Payment Mode',['class'=>'form-label']) }}
                        {{ Form::select('security_deposit_payment_mode',paymentModeOptions(),'Direct Payment',['wire:model'=>'checkin.security_deposit_payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'security_deposit_payment_mode']) }}</td>
                    <th>
                        {{ Form::label('security_amount','Security Amount',['class'=>'form-label']) }}
                        {{ Form::number('security_amount','',['wire:model'=>'checkin.security_amount','min'=>0,'class'=>'form-control','placeholder'=>'enter only if any extra amount collected as security amount']) }}
                    </th>
                </tr>
            </table>
            @endif
            <div class="text-light small fw-semibold">Advance Details</div>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th wire:ignore width="50%">
                        {{ Form::label('payment_mode','Payment Mode',['class'=>'form-label']) }}
                        {{ Form::select('payment_mode',paymentModeOptions(),'Direct Payment',['wire:model'=>'checkin.payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'payment_mode']) }}</td>
                    <th>
                        {{ Form::label('advance_amount','Advance Amount',['class'=>'form-label']) }}
                        {{ Form::number('advance_amount','',['wire:model'=>'checkin.advance_amount','min'=>0,'class'=>'form-control','placeholder'=>'enter only if any extra amount collected as Advance Amount']) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        {{ Form::label('advance_reason','Advance Remarks',['class'=>'form-label']) }}
                        {{ Form::text('advance_reason','',['wire:model'=>'checkin.advance_reason','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Advance Reason']) }}
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header sticky-element d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
            <h5 class="card-title mb-sm-0"> </h5>
            <div class="action-btns">
                @if(!$rentout->checkout)
                @if($rentout['status']!=Rentout::CheckIn)
                @if(\Permissions::Allow('Checkin.Create'))
                <button type="button" class="btn btn-primary" wire:click="save('{{ Rentout::CheckIn }}')">Save & Check In</button>
                @endif
                @endif
                @endif
                <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingContractPrint',$rentout['id']) }}"> Booking Contract Print </a>&nbsp; &nbsp; &nbsp; &nbsp;
                <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingSummaryPrint',$rentout['id']) }}"> Booking Summary Print </a>
            </div>
        </div>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('#security_deposit_payment_mode').change();
            $('#security_deposit_payment_mode').on('change', function (e) {
                @this.set('checkin.security_deposit_payment_mode', $(this).val());
            });
            $('#payment_mode').change();
            $('#payment_mode').on('change', function (e) {
                @this.set('checkin.payment_mode', $(this).val());
            });
        });
    </script>
    @stop
</div>