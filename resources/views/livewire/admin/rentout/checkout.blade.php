<?php use App\Models\CheckoutPayment; ?>
<div>
    <form wire:submit.prevent="save">
        <div class="card mb-2">
            <div class="row">
                <div class="col-md-12">
                    @if($this->getErrorBag()->count())
                    <ol>
                        <?php foreach ($this->getErrorBag()->toArray() as $key => $value): ?>
                        <li style="color:red">* {{ $value[0] }}</li>
                        <?php endforeach; ?>
                    </ol>
                    @endif
                </div>
            </div>
        </div>
        @if(!$checkout_id)
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-11" wire:ignore>
                                {{ Form::select('rentout_ids',$RentoutRooms,'',['wire:model'=>'rentout_ids','class'=>'form-control select2_class','multiple','id'=>'rentout_ids']) }}
                                {{ Form::label('rentout_ids','Room No : ',['class'=>'form-label']) }} <i class="p-2 text-end">Room No - Customer Name - Mobile</i>
                            </div>
                            <div class="col-md-1">
                                <button type="button" wire:click="get" class="btn btn-primary" name="button">Get</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="text-light small fw-semibold">Check In Details</div>
                        @if($Customer)
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="150">Name</th>
                                    <td>{{ $Customer->customer->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Room No</th>
                                    <td>
                                        <?php foreach ($Customer->rentoutRooms as $key => $value): ?>
                                        @if($key),@endif {{ $value->room->room_no }}
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Booking No.</th>
                                    <td>{{ $Customer->booking_no }}</td>
                                </tr>
                                <tr>
                                    <th>Email ID</th>
                                    <td>{{ $Customer->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile No</th>
                                    <td>{{ $Customer->customer->mobile }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $Customer->customer->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-2">
                    <h5 class="card-header">Set Default Customer</h5>
                    <div class="card-body">
                        <?php foreach ($SelectedRentouts as $key => $value): ?>
                        <div class="row">
                            <div class="col-md mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic checked">
                                    <label class="form-check-label custom-option-content" for="customer_name_{{ $value['id'] }}">
                                        <input name="customRadioTemp" wire:model="checkouts.rentout_id" class="form-check-input" type="radio" value="{{ $value['id'] }}" id="customer_name_{{ $value['id'] }}" @if($checkouts['rentout_id']) @if($checkouts['rentout_id']==$value['id']) checked @endif @endif>
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">
                                                {{ $value->id }} :
                                                <?php foreach ($value->rentoutRooms as $rentoutRoomKey => $rentoutRoomValue): ?>
                                                @if($rentoutRoomKey),@endif {{ $rentoutRoomValue->room->room_no }}
                                                <?php endforeach; ?>
                                            </span>
                                            <span>Customer : {{ $value->customer->full_name }}</span>
                                        </span>
                                        <span class="custom-option-body">
                                            <small>{{ systemDateTime($value->check_in_date).' - ' .systemDateTime($value->check_out_date) }}</small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="col-md-12">
                        <table class="table border-top  table-sm table-bordered  ">
                            <thead>
                                <tr>
                                    <th rowspan="2">Date</th>
                                    <th colspan="10" class="text-center">Room Rent Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($SelectedRentouts as $key => $value): ?>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>{{ systemDateTime($value->check_in_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ systemDateTime($value->check_out_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td> No Of Adults : {{ $value->no_of_adult }}</td>
                                            </tr>
                                            <tr>
                                                <td>No Of Children : {{ $value->no_of_children }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="10">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-end">#</th>
                                                    <th class="text-end">No Of Days</th>
                                                    <th class="text-end">Room No</th>
                                                    <th>Type</th>
                                                    <th class="text-end">Rent/Day</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-end">Tax</th>
                                                    <th class="text-end">Grand Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($value->rentoutRooms as $rentoutRoomKey => $rentoutRoomValue)
                                                <tr>
                                                    <td class="text-end">{{ $loop->iteration }}</td>
                                                    <td class="text-end">{{ $rentoutRoomValue->roomDates->count() }}</td>
                                                    <td class="text-end">{{ $rentoutRoomValue->room->room_no}}</td>
                                                    <td>{{ $rentoutRoomValue->room->type }}</td>
                                                    <td class="text-end">{{ currency($rentoutRoomValue->amount) }}</td>
                                                    <td class="text-end">{{ currency($rentoutRoomValue->roomDates->sum('amount')) }}</td>
                                                    <td class="text-end">{{ currency($rentoutRoomValue->roomDates->sum('tax')) }}</td>
                                                    <td class="text-end">{{ currency($rentoutRoomValue->roomDates->sum('amount')) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="card mb-2">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Additional Charges</h6>
                    </div>
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
            <div class="col-md-4">
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
            <div class="col-md-5">
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
    </form>
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rentout_ids').on('select2:select change', function (e) {
                @this.set('rentout_ids', $(this).val());
            });
            $('#payment_mode').change();
            window.addEventListener('SelectRoomFlag', event => {
                $('#room_id').val('').change();
                $('#room_id').select2('open');
            });
            window.addEventListener('SelectCustomerFlag', event => {
                $('#customer_id').val('').change();
                $('#customer_id').select2('open');
            });
            window.addEventListener('FormRefreshEvent', event => {
                $('#agent_id').val('').change();
            });
            $('#payment_mode').on('select2:select change', function (e) {
                @this.set('payment.payment_mode', $(this).val());
            });
            $('#security_deposit_payment_mode').change();
            $('#security_deposit_payment_mode').on('select2:select change', function (e) {
                @this.set('checkouts.security_deposit_payment_mode', $(this).val());
            });
        });
    </script>
    @stop
</div>