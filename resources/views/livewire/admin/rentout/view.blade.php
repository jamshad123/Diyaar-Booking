<div>
    <div class="row">
        <div class="card mb-2">
            <div class="card-body">
                <div class="text-light fw-semibold">Room Details</div>
                <div class="row mb-1">
                    <table class="table table-sm table-bordered table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-end">ROOM NO</th>
                                <th>FLOOR</th>
                                <th class="text-end">NO OF BEDS</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th class="text-end">No Of Days</th>
                                <th class="text-end">PRICE</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentout->rentoutRooms as $rooms)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td class="text-end">{{ $rooms->room->room_no}}</td>
                                <td>{{ $rooms->room->floor}}</td>
                                <td class="text-end">{{ $rooms->room->no_of_beds}}</td>
                                <td>{{ systemDate($rooms->check_in_date) }}</td>
                                <td>{{ systemDate($rooms->check_out_date) }}</td>
                                <td class="text-end">{{ $rooms->no_of_days}}</td>
                                <td class="text-end">{{ currency($rooms->amount) }}</td>
                                <td class="text-end">{{ currency($rooms->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h3> Booking Status = {{ $rentout->status }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Booking Details</div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>Booking No</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                            <tr>
                                <td>{{ $rentout->id }}</td>
                                <td>{{ systemDateTime($rentout->check_in_date) }}</td>
                                <td>{{ systemDateTime($rentout->check_out_date) }}</td>
                            </tr>
                            <tr>
                                <th>No Of Room</th>
                                <th>No Of Days</th>
                                <th>Extra Beds</th>
                            </tr>
                            <tr>
                                <td>{{ count($rentout->rentoutRooms) }}</td>
                                <td>{{ $rentout->days() }}</td>
                                <td>{{ $rentout->extra_beds }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if($rentout->agent)
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Agent Information</div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>Agent</th>
                                <th>Contact No</th>
                                <th>Agent Id</th>
                                <th>ID Proof</th>
                            </tr>
                            <tr>
                                <td>{{ $rentout->agent->full_name }}</td>
                                <td>{{ $rentout->agent->mobile }}</td>
                                <td>{{ $rentout->agent->document_type }}</td>
                                <td>
                                    @if($rentout->agent->id_no){{ $rentout->agent->id_no }} <br> @endif
                                    @if($rentout->agent->iqama_no) {{ $rentout->agent->iqama_no }} <br> @endif
                                    @if($rentout->agent->visa_no) {{$rentout->agent->visa_no }} <br> @endif
                                    @if($rentout->agent->passport_no) {{$rentout->agent->passport_no }} <br> @endif
                                    @if($rentout->agent->qccid_no) {{ $rentout->agent->qccid_no }} <br> @endif
                                    @if($rentout->agent->issue_place){{ $rentout->agent->issue_place }} <br> @endif
                                    @if($rentout->agent->expiry_date){{ $rentout->agent->expiry_date }} <br> @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Customer Information</div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact No</th>
                                <th>Id Type</th>
                                <th>ID Proof</th>
                            </tr>
                            <tr>
                                <td>{{ $rentout->customer->full_name }}</td>
                                <td>{{ $rentout->customer->mobile }}</td>
                                <td>{{ $rentout->customer->document_type }}</td>
                                <td>
                                    @if($rentout->customer->id_no){{ $rentout->customer->id_no }} <br> @endif
                                    @if($rentout->customer->iqama_no) {{ $rentout->customer->iqama_no }} <br> @endif
                                    @if($rentout->customer->visa_no) {{$rentout->customer->visa_no }} <br> @endif
                                    @if($rentout->customer->passport_no) {{$rentout->customer->passport_no }} <br> @endif
                                    @if($rentout->customer->qccid_no) {{ $rentout->customer->qccid_no }} <br> @endif
                                    @if($rentout->customer->issue_place){{ $rentout->customer->issue_place }} <br> @endif
                                    @if($rentout->customer->expiry_date){{ $rentout->customer->expiry_date }} <br> @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Adults</th>
                                <th>Children</th>
                                <th>Arrival From</th>
                                <th>Purpose of Visit</th>
                            </tr>
                            <tr>
                                <th>{{ $rentout->no_of_adult}}</th>
                                <th>{{ $rentout->no_of_children }}</th>
                                <th>{{ $rentout->arrival_from}}</th>
                                <th>{{ $rentout->purpose_of_visit }}</th>
                            </tr>
                            @if($rentout->remarks)
                            <tr>
                                <th colspan="4">{{ $rentout->remarks }}</th>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Payment Information</div>
                    <div class="text-light fw-semibold"> </div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>TOTAL</th>
                                <td class="text-end"> <b>{{ currency($rentout->total) }}</b> </td>
                            </tr>
                            <tr>
                                <th>TAX ({{ percentage($rentout['tax_percentage']) }})</th>
                                <td class="text-end"> <b>{{ currency($rentout->tax) }}</b> </td>
                            </tr>
                            <tr>
                                <th>DISCOUNT</th>
                                <td class="text-end"> <b>{{ currency($rentout->discount_amount) }}</b> </td>
                            </tr>
                            <tr>
                                <th>GRAND TOTAL</th>
                                <td class="text-end"> <b>{{ currency($rentout->grand_total) }}</b> </td>
                            </tr>
                            @if($rentout->security_amount)
                            <tr>
                                <th>Security Deposite ({{ $rentout->security_deposit_payment_mode }})</th>
                                <td class="text-end"> <b>{{ currency($rentout->security_amount) }}</b> </td>
                            </tr>
                            @endif
                            <tr>
                                <th>
                                    <h5>Advance Paid ({{ $rentout->payment_mode }})</h5>
                                </th>
                                <td class="text-end">
                                    <h5> {{ currency($rentout->advance_amount) }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <td class="text-end"> <b> {{ currency($rentout->grand_total - $rentout->advance_amount) }}</b> </td>
                            </tr>
                            @if($rentout->advance_reason)
                            <tr>
                                <td colspan="2"> ADVANCE REMARKS <b> : {!! $rentout->advance_reason !!}</b> </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @if($rentout->checkout)
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Checkout Information</div>
                    <div class="text-light fw-semibold"> </div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>Last Update Date</th>
                                <td class="text-end"> <b>{{ systemDate($rentout->checkout->updated_at) }}</b> </td>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->total) }} +</b> </td>
                            </tr>
                            <tr>
                                <th>TAX ({{ percentage($rentout['tax_percentage']) }})</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->tax) }} +</b> </td>
                            </tr>
                            <tr>
                                <th>DISCOUNT</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->discount_amount) }} -</b> </td>
                            </tr>
                            <tr>
                                <th>GRAND TOTAL</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->grand_total) }} = </b> </td>
                            </tr>
                            @if($rentout->security_amount)
                            <tr>
                                <th>Security Deposite ({{ $rentout->security_deposit_payment_mode }})</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->security_amount) }}</b> </td>
                            </tr>
                            @endif
                            <tr>
                                <th>
                                    <h5>Advance Paid ({{ $rentout->payment_mode }})</h5>
                                </th>
                                <td class="text-end">
                                    <h5> {{ currency($rentout->advance_amount) }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <th>PAYABLE AMOUNT</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->grand_total - $rentout->checkout->advance_amount) }}</b> </td>
                            </tr>
                            <tr>
                                <th>Paid</th>
                                <td class="text-end"> <b>{{ currency($rentout->checkout->paid) }}</b> </td>
                            </tr>
                            <tr>
                                <th>
                                    <h3>Balance Due</h3>
                                </th>
                                <td class="text-end">
                                    <h3>{{ currency($rentout->checkout->balance) }}</h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="text-light fw-semibold">Payment Details</div>
                    <div class="text-light fw-semibold"> </div>
                    <div class="row mb-1">
                        <table class="table table-sm table-bordered table-hover table-sm table-striped">
                            <tr>
                                <th>PAYMENT MODE</th>
                                <th>Date</th>
                                <th class="text-end">Amount</th>
                                @if(\Permissions::Allow('Checkout.Payment Delete'))
                                <th>Action</th>
                                @endif
                            </tr>
                            <tbody>
                                @foreach($rentout->checkout->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_mode}}</td>
                                    <td>{{ systemDate($payment->created_at) }}</td>
                                    <td class="text-end">
                                        <a target="_blank" href="{{ route('Rentout::checkout::receipt_print',$payment['id']) }}"><i class="fa fa-print"></i></a>
                                        {{ currency($payment->amount) }}
                                    </td>
                                    @if(\Permissions::Allow('Checkout.Payment Delete'))
                                    <td>
                                        <button type="button" wire:click="RemovePayment('{{ $payment->id }}')" class="btn btn-sm btn-danger" name="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>