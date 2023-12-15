<div>
    <form wire:submit.prevent="save">
        <div class="row mb-2">
            @if(\Permissions::Allow('Booking.Additional Charge') || \Permissions::Allow('Checkout.Discount'))
            <div class="col">
                @if(\Permissions::Allow('Booking.Additional Charge'))
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="col">
                            <span>Additional Charges</span>
                            <input type="number" wire:model="checkouts.additional_charges" step="any" class="form-control" min="0">
                        </div>
                        <div class="col">
                            <span>Additional Charge Comments</span>
                            <textarea name="name" wire:model="checkouts.additional_charge_comments" class="form-control" rows="2" cols="80"></textarea>
                        </div>
                    </div>
                </div>
                @endif
                @if(\Permissions::Allow('Checkout.Discount'))
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Special Discount</h6>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <span>Discount Amount</span>
                            <input type="number" wire:model="checkouts.special_discount_amount" step="any" class="form-control" min="0">
                        </div>
                        <div class="col">
                            <span>Discount Reason</span>
                            <textarea name="name" wire:model="checkouts.special_discount_reason" class="form-control" rows="2" cols="80"></textarea>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <div class="col">
                <div class="card mb-2">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Billing Details</h6>
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th> <i>Security Deposit</i> </th>
                                    <td class="text-end"> <i>{{ currency($checkouts['security_deposit']) }}</i> </td>
                                </tr>
                                <tr>
                                    <th>Extra Beds</th>
                                    <td class="text-end">{{ currency($checkouts['extra_bed_charge']) }} + </td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="text-end">{{ currency($checkouts['total']) }} + </td>
                                </tr>
                                <tr>
                                    <th>Tax({{ percentage($tax_percentage) }})</th>
                                    <td class="text-end">{{ currency($checkouts['tax']) }} + </td>
                                </tr>
                                <tr>
                                    <th>Additional Charges</th>
                                    <td class="text-end">{{ currency($checkouts['additional_charges']) }} + </td>
                                </tr>
                                <tr>
                                    <th>Booking Discount</th>
                                    <td class="text-end">{{ currency($checkouts['booking_discount_amount']) }} - </td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td class="text-end">{{ currency($checkouts['special_discount_amount']) }} - </td>
                                </tr>
                                <tr>
                                    <th>Grand Total</th>
                                    <td class="text-end">{{ currency($checkouts['grand_total']) }} = </td>
                                </tr>
                                <tr>
                                    <th>Advance Amount</th>
                                    <td class="text-end">{{ currency($checkouts['advance_amount']) }} - </td>
                                </tr>
                                <tr>
                                    <th>Payable Amount</th>
                                    <td class="text-end">{{ currency($checkouts['grand_total']-$checkouts['advance_amount']) }} = </td>
                                </tr>
                                <tr>
                                    <th>Paid</th>
                                    <td class="text-end">{{ currency($checkouts['paid']) }} - </td>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <td class="text-end">{{ currency($checkouts['balance']) }} = </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                @if(\Permissions::Allow('Booking.Security deposit'))
                <div class="card mb-2">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Security Deposit Return</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped">
                            <tr>
                                <th wire:ignore width="50%">
                                    {{ Form::label('security_deposit_payment_mode','Payment Mode',['class'=>'form-label']) }}
                                    {{ Form::select('security_deposit_payment_mode',paymentModeOptions(),'Direct Payment',['wire:model'=>'checkouts.security_deposit_payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'security_deposit_payment_mode']) }}</td>
                                <th>
                                    {{ Form::label('security_amount','Security Deposit Return Amount',['class'=>'form-label']) }}
                                    {{ Form::number('security_amount','',['wire:model'=>'checkouts.security_amount','min'=>0,'class'=>'form-control','placeholder'=>'Please add Security Deposite']) }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    {{ Form::label('security_reason','Remarks',['class'=>'form-label']) }}
                                    {{ Form::text('security_reason','',['wire:model'=>'checkouts.security_reason','class'=>'form-control','placeholder'=>'Please Enter Any Reason']) }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Bill Settlement</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="45%">Payment Mode</th>
                                    <th width="40%">Amount</th>
                                    <th width="5%">Action</th>
                                </tr>
                                <tr>
                                    <td width="45%" wire:ignore>{{ Form::select('payment_mode',paymentModeOptions(),'Direct Payment',['wire:model'=>'payment.payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'payment_mode']) }}</td>
                                    <td width="40%"><input style="width:100%" type="number" class="form-control" wire:model="payment.amount" min="0"> </td>
                                    <td width="5%"> <button type="button" wire:click="AddPayment" class="btn btn-sm btn-primary" name="button"><i class="fa fa-plus"></i></button> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $key => $value): ?>
                                <tr>
                                    <td>{{ $value['payment_mode'] }}</td>
                                    <td class="text-end">
                                        @if(isset($value['id']))
                                        <a target="_blank" href="{{ route('Rentout::checkout::receipt_print',$value['id']) }}"><i class="fa fa-print"></i></a>
                                        @endif
                                        <span>{{ currency($value['amount']) }}</span>
                                    </td>
                                    <td width="5%">
                                        <button type="button" wire:click="RemovePayment('{{ $key }}')" class="btn btn-sm btn-danger" name="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header sticky-element  d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0">
                    </h5>
                    <div class="action-btns">
                        @if($checkout_id)
                        <a href="{{ route('Rentout::checkout::checkout_print',$checkout_id) }}" class="btn btn-info"> Print </a>
                        <button type="submit" class="btn btn-primary"> Save </button>
                        @else
                        <button type="submit" class="btn btn-primary">Check Out </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>