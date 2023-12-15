<?php use App\Models\Rentout; ?>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="text fw-bold">Check In Details</div>
                        <div class="row mb-1">
                            <div class="col-md-2 col-sm-6" wire:ignore>
                                {{ Form::label('check_in_date','Check In Date ',['class'=>'form-label']) }}<span style="color: red;"> *</span>
                                {{ Form::text('check_in_date','',['wire:model'=>'rentouts.check_in_date','class'=>'form-control','placeholder'=>'Please Enter Check In Date','id'=>'main_check_in_date']) }}
                            </div>
                            <div class="col-md-2 col-sm-6" wire:ignore>
                                {{ Form::label('check_out_date', 'Check Out Date', ['class' => 'form-label']) }}<span style="color: red;"> *</span>
                                {{ Form::text('check_out_date', '', ['wire:model' => 'rentouts.check_out_date', 'class' => 'form-control', 'placeholder' => 'Please Enter Check Out Date', 'id' => 'main_check_out_date']) }}
                            </div>

                            @if(\Permissions::Allow('Booking.Agent'))
                            <div class="col-md-4 col-sm-12" wire:ignore>
                                {{ Form::label('agent_id','Travel Agent',['class'=>'form-label']) }}
                                {{ Form::select('agent_id',$agents,'',['wire:model'=>'rentouts.agent_id','class'=>'form-control select2-agent_id','placeholder'=>'Please Select Agent','id'=>'agent_id']) }}
                            </div>
                            @endif
                            <div class="col-md-4 col-sm-12" wire:ignore>
                                {{ Form::label('company_id','Company',['class'=>'form-label']) }}
                                {{ Form::select('company_id',$companies,'',['wire:model'=>'rentouts.company_id','class'=>'form-control select2-company_id','placeholder'=>'Please Select Company','id'=>'company_id']) }}
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-4 col-sm-12" style="display: flex; flex-direction: row; gap: 5px; align-items: flex-start;"> --}}
                                <div class="col-md-2 col-sm-4">
                                    {{ Form::label('days','Days',['class'=>'form-label']) }}
                                    {{ Form::number('days','',['wire:model'=>'rentouts.days','class'=>'form-control','min'=>1,'placeholder'=>'No Of Days']) }}
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    {{ Form::label('num_adult','No of adult',['class'=>'form-label']) }}
                                    {{ Form::number('num_adult','',['wire:model'=>'rentouts.num_adult','class'=>'form-control','min'=>1,'placeholder'=>'No Of Adult']) }}
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    {{ Form::label('num_child','No of Child',['class'=>'form-label']) }}
                                    {{ Form::number('num_child','',['wire:model'=>'rentouts.num_child','class'=>'form-control','min'=>1,'placeholder'=>'No Of Child']) }}
                                </div>
                            {{-- </div> --}}
                             <div class="col-md-2 col-sm-12">
                                 {{ Form::label('extra_beds','Extra Beds',['class'=>'form-label']) }}
                                 {{ Form::number('extra_beds','',['wire:model'=>'rentouts.extra_beds','min'=>'0','step'=>'1','class'=>'form-control number','placeholder'=>'Enter the Extra Bed count']) }}
                             </div>
                             <div class="col-md-4 col-sm-12">
                                {{ Form::label('min_per_day_rent','Min Per Day Rent',['class'=>'form-label']) }}
                                {{ Form::number('min_per_day_rent','',['wire:model'=>'min_per_day_rent','min'=>'0','class'=>'form-control number','placeholder'=>'Please Enter the Per Day Rent','disabled']) }}
                            </div>
        
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12" wire:ignore>
                                {{ Form::label('company_id','Company',['class'=>'form-label']) }}
                                {{ Form::select('company_id',$companies,'',['wire:model'=>'rentouts.company_id','class'=>'form-control select2-company_id','placeholder'=>'Please Select Company','id'=>'company_id']) }}
                            </div>
                            {{-- <div class="col-md-2 col-sm-12 text-center">
                                {{ Form::label('min_per_day_rent','Min Per Day Rent',['class'=>'form-label']) }}
                                {{ Form::number('min_per_day_rent','',['wire:model'=>'min_per_day_rent','min'=>'0','class'=>'form-control number text-center','placeholder'=>'Please Enter the Per Day Rent','disabled']) }}
                            </div> --}}
                            {{-- <div class="col-md-2 col-sm-12"> --}}
                                {{-- {{ Form::label('min_per_day_rent','Min Per Day Rent',['class'=>'form-label']) }} --}}
                                {{-- {{ Form::number('min_per_day_rent','',['wire:model'=>'min_per_day_rent','min'=>'0','class'=>'form-control number','placeholder'=>'Please Enter the Per Day Rent','disabled']) }} --}}
                            {{-- </div> --}}
                            <div class="col-md-4 col-sm-12">
                                {{ Form::label('purpose_of_visit','Purpose Of Visit',['class'=>'form-label']) }}
                                {{ Form::select('purpose_of_visit',purposeOfVisits(),'',['wire:model'=>'rentouts.purpose_of_visit','class'=>'form-control','placeholder'=>'Please Enter Purpose Of Visit']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
              <div class="card mb-5">
                @if(!in_Array($rentouts['status'],[Rentout::CheckOut,Rentout::Cancelled]))
                @if(
                \Permissions::Allow('Booking.Create') ||
                \Permissions::Allow('Booking.Edit') ||
                \Permissions::Allow('Checkin.Create') ||
                \Permissions::Allow('Checkin.Edit')
                )
                <div class="d-flex justify-content-between align-items-center" style="padding: 12px 15px;">
                    <div class="text fw-bold">Customer Details</div>
                    {{-- <div>
                        <a href="#" data-bs-target="#CustomerModal" data-bs-toggle="modal" class="btn btn-primary" style="margin-right: 10px;"><i class="far fa-plus"></i> New Customer</a>
                        <a href="#" data-bs-target="#AddExistingCustomerModal" data-bs-toggle="modal" class="btn btn-secondary"><i class="far fa-plus"></i> Old Customer</a>
                    </div> --}}
                </div>
               <div class="table-responsive" style="height: 150px;margin: 10px 10px;overflow-x: auto;">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #d9dee3;">
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Id Proof</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $key => $value)
                                <tr>
                                    <td class="text-center">
                                        <input name="customRadioTemp" wire:model="rentouts.customer_id" class="form-check-input" type="radio" value="{{ $value['customer_id'] }}" id="customer_name_{{ $value['customer_id'] }}" @if($rentouts['customer_id']) @if($rentouts['customer_id']==$value['customer_id']) checked @endif @endif>
                                    </td>
                                    <td>{{ $value['name'] }}</td>
                                    <td>IND</td>
                                    <td>3748567623478534</td>
                                    <td>{{ $value['mobile'] }}</td>
                                    <td class="text-center">
                                        @if(!in_Array($rentouts['status'], [Rentout::CheckOut, Rentout::Cancelled]))
                                            @if(\Permissions::Allow('Booking.Edit') || \Permissions::Allow('Checkin.Edit'))
                                                <i wire:click="RemoveCustomer({{$key}})" class="far fa-trash-alt text-danger cursor-pointer" style="margin-right: 10px;"></i>
                                            @endif
                                        @endif
                                        {{-- <a href="#" data-bs-target="#CustomerModal" data-bs-toggle="modal" class="btn btn-sm btn-primary" style="margin-right: 5px;"><i class="far fa-plus"></i></a> --}}
                                        {{-- <a href="#" data-bs-target="#AddExistingCustomerModal" data-bs-toggle="modal" class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></a> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between" style="justify-content: normal!important ">
                                        <a href="#" data-bs-target="#CustomerModal" data-bs-toggle="modal" class="btn btn-sm btn-primary" style="margin-right: 10px;"><i class="far fa-plus"></i></a>
                                        <a href="#" data-bs-target="#AddExistingCustomerModal" data-bs-toggle="modal" class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>



                </div>

                @endif
                @endif


            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                           <div class="col">
                               {{ Form::label('no_of_adult','No Of Adults',['class'=>'form-label']) }}
                               {{ Form::number('no_of_adult','',['wire:model'=>'rentouts.no_of_adult','min'=>'0','class'=>'form-control number','placeholder'=>'Please Enter the no']) }}
                           </div>
                           <div class="col">
                               {{ Form::label('no_of_children','No Of Child',['class'=>'form-label']) }}
                               {{ Form::number('no_of_children','',['wire:model'=>'rentouts.no_of_children','min'=>'0','class'=>'form-control number','placeholder'=>'Please Enter the no']) }}
                           </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card mb-2">
                    <div class="card-body" style="max-height: 350px; overflow-y: auto;padding-top: 10px!important;">
                        <div class="row" style="flex-direction: row-reverse;padding-bottom:10px;">
                            @if(!in_Array($rentouts['status'],[Rentout::CheckOut,Rentout::Cancelled]))
                            <div class="col-md-2"> 
                                <button type="button" wire:click="SelectRoom" class="btn btn-primary" style="width:100%">
                                    <i class="bi bi-plus-square"></i>Select Room
                                </button>
                            </div>
                            @endif
                        </div>
                        <table class="table table-sm table-bordered table-hover table-sm table-striped" >
                            <thead>
                                <th class="text-end">#</th>
                                <th class="text-end">From</th>
                                <th class="text-end">To</th>
                                <th class="text-end">Room No</th>
                                <th>Floor</th>
                                <th class="text-end">No Of Beds</th>
                                <th class="text-end">Per day price</th>
                                <th class="text-end">No Of Days</th>
                                <th class="text-end">Total</th>
                                @if(!in_Array($rentouts['status'],[Rentout::CheckOut,Rentout::Cancelled]))
                                @if(\Permissions::Allow('Booking.Edit') || \Permissions::Allow('Checkin.Edit'))
                                <th width="5%">Action</th>
                                @endif
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($rentout_rooms as $key => $value)
                                <tr class="@if($value['hygiene_status']=='Dirty') table-warning @else table-info @endif">
                                    <td class="text-end">{{ $loop->iteration }}</td>
                                    <td class="text-end">{{ systemDate($value['check_in_date']) }}</td>
                                    <td class="text-end">{{ systemDate($value['check_out_date']) }}</td>
                                    <td class="text-end">{{ $value['room_no']}}</td>
                                    <td>{{ $value['floor'] }}</td>
                                    <td class="text-end">{{ $value['no_of_beds'] }}</td>
                                    <td class="text-end">{{ $value['no_of_days'] }}</td>
                                    <td class="text-end" width="10%">
                                        <input type="number" class="form-control form-control-sm number" min="{{ $min_per_day_rent }}" wire:model="rentout_rooms.{{ $key }}.price" wire:change="UpdateRoomPrice('{{ $key }}')" wire:keyup="UpdateRoomPrice('{{ $key }}')">
                                    </td>
                                    <td class="text-end">{{ currency($value['total']) }}</td>
                                    @if(!in_Array($rentouts['status'],[Rentout::CheckOut,Rentout::Cancelled]))
                                    @if(\Permissions::Allow('Booking.Edit') || \Permissions::Allow('Checkin.Edit'))
                                    <td><i wire:click="RemoveRoom('{{$key}}')" class="far fa-trash-alt pointer_class"></i></td>
                                    @endif
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end">Total</td>
                                    <td class="text-end">{{ array_sum(array_column($rentout_rooms,'no_of_beds')) }}</td>
                                    <td colspan="2" class="text-end"></td>
                                    <td class="text-end">{{ currency(array_sum(array_column($rentout_rooms,'total'))) }}</td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
             </div>
            </div>
        </div>
        <div class="row">
        </div>
         <div class="row mb-2">
             <div class="col-md-12">
                 <div class="row">
                     <div class="col-md-8" style="padding-top: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="col-md-4 text medium fw-bold d-flex " style="padding: 20px 20px;">Security Amount</div>
       
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check  mb-3">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" id="direct_payment" checked data-reference="directPaymentReferenceField">
                                                    <label class="form-check-label" for="direct_payment">
                                                        Direct Payment
                                                    </label>
                                                    <div class="referenceFields" id="directPaymentReferenceField" style="display: none; padding-top: 10px;">
                                                        <div class="form-group">
                                                            <label for="directPaymentReferenceNumber">Reference Number:</label>
                                                            <input type="text" class="form-control" id="directPaymentReferenceNumber" placeholder="Enter reference number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check  mb-3">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" id="paypal" data-reference="netBankingReferenceField">
                                                    <label class="form-check-label" for="paypal">
                                                        Net Banking
                                                    </label>
                                                    <div class="referenceFields" id="netBankingReferenceField" style="display: none; padding-top: 10px;">
                                                        <div class="form-group">
                                                            <label for="netBankingReferenceNumber">Reference Number:</label>
                                                            <input type="text" class="form-control" id="netBankingReferenceNumber" placeholder="Enter reference number">
                                                        </div>
                                                    </div>
                                                </div>
       
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" data-reference="cardPaymentReferenceField">
                                                    <label class="form-check-label" for="creditCard">
                                                        Card Payment
                                                    </label>
                                                    <div class="referenceFields" id="cardPaymentReferenceField" style="display: none; padding-top: 10px;">
                                                        <div class="form-group">
                                                            <label for="cardPaymentReferenceNumber">Reference Number:</label>
                                                            <input type="text" class="form-control" id="cardPaymentReferenceNumber" placeholder="Enter reference number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check  mb-3">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" id="upi" data-reference="upiReferenceField">
                                                    <label class="form-check-label" for="upi">
                                                        UPI
                                                    </label>
                                                    <div class="referenceFields" id="upiReferenceField" style="display: none; padding-top: 10px;">
                                                        <div class="form-group">
                                                            <label for="upiReferenceNumber">Reference Number:</label>
                                                            <input type="text" class="form-control" id="upiReferenceNumber" placeholder="Enter reference number">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
       
                                            <div class="col-md-6">
                                                <div class="row">

                                                    {{-- <h5 style="margin-left: 32px;">Security Amount</h5> --}}
                                                    <label for="total_amount" class="text medium fw-bold d-flex" style="margin-left: 44px;">Security Amount</label>

                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center justify-content-center" style="padding: 10px;padding-left: 29px!important; border-radius: 5px; width: 100%;">
                                                            <label for="securityAmount" class="sr-only">Advance Amount:</label>
                                                            <input type="number" class="form-control border" id="securityAmount" value="500" step="1" style="width: 80%;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-12" style="padding-top: 7px!important;">
                                                            <button type="button" class="btn btn-primary btn-sm mt-2">Submit</button>
                                                        </div>
                                                    </div>
                                                                                                                         
                                                </div>
                                                <div class="row mt-6" style="margin-top: 80px;">
                                                    <div class="col-md-6" >
                                                        <label for="total_amount" class="text medium fw-bold d-flex" style="margin-left: 50px;padding-top: 5px;">Total Amount</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" value="500" disabled>
                                                    </div>
                                                  
                                                </div>
                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card">
                                    <div class="card mt-2">
                                        <div class="col-md-4 text medium fw-bold d-flex " style="padding: 20px 20px;">Advance Detail</div>
       
                                        <div class="card-body">
       
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check  mb-3">
                                                        <input class="form-check-input" type="radio" name="advancePaymentMethod" id="advance_direct_payment" checked data-reference="advanceDirectPaymentReferenceField">
                                                        <label class="form-check-label" for="advance_direct_payment">
                                                            Direct Payment
                                                        </label>
                                                        <div class="advanceReferenceFields" id="advanceDirectPaymentReferenceField" style="display: none; padding-top: 10px;">
                                                            <div class="form-group">
                                                                <label for="advanceDirectPaymentReferenceNumber">Reference Number:</label>
                                                                <input type="text" class="form-control" id="advanceDirectPaymentReferenceNumber" placeholder="Enter reference number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check  mb-3">
                                                        <input class="form-check-input" type="radio" name="advancePaymentMethod" id="advance_paypal" data-reference="advanceNetBankingReferenceField">
                                                        <label class="form-check-label" for="advance_paypal">
                                                            Net Banking
                                                        </label>
                                                        <div class="advanceReferenceFields" id="advanceNetBankingReferenceField" style="display: none; padding-top: 10px;">
                                                            <div class="form-group">
                                                                <label for="advanceNetBankingReferenceNumber">Reference Number:</label>
                                                                <input type="text" class="form-control" id="advanceNetBankingReferenceNumber" placeholder="Enter reference number">
                                                            </div>
                                                        </div>
                                                    </div>
       
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="advancePaymentMethod" id="advance_creditCard" data-reference="advanceCardPaymentReferenceField">
                                                        <label class="form-check-label" for="advance_creditCard">
                                                            Card Payment
                                                        </label>
                                                        <div class="advanceReferenceFields" id="advanceCardPaymentReferenceField" style="display: none; padding-top: 10px;">
                                                            <div class="form-group">
                                                                <label for="advanceCardPaymentReferenceNumber">Reference Number:</label>
                                                                <input type="text" class="form-control" id="advanceCardPaymentReferenceNumber" placeholder="Enter reference number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check  mb-3">
                                                        <input class="form-check-input" type="radio" name="advancePaymentMethod" id="advance_upi" data-reference="advanceUpiReferenceField">
                                                        <label class="form-check-label" for="advance_upi">
                                                            UPI
                                                        </label>
                                                        <div class="advanceReferenceFields" id="advanceUpiReferenceField" style="display: none; padding-top: 10px;">
                                                            <div class="form-group">
                                                                <label for="advanceUpiReferenceNumber">Reference Number:</label>
                                                                <input type="text" class="form-control" id="advanceUpiReferenceNumber" placeholder="Enter reference number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check  mb-3">
                                                        <input class="form-check-input" type="radio" name="advancePaymentMethod" id="advance_coupon" data-reference="advanceCouponReferenceField">
                                                        <label class="form-check-label" for="advance_coupon">
                                                            Have a Coupon Code:                                                       
                                                       </label>
                                                        <div class="advanceReferenceFields" id="advanceCouponReferenceField" style="display: none; padding-top: 10px;">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" id="couponCode"
                                                                               placeholder="Enter coupon code">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="button" class="btn btn-primary" id="applyCouponBtn">
                                                                            Apply
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">

                                                        <label for="total_amount" class="text medium fw-bold d-flex" style="margin-left: 44px;">Advance Amount</label>

                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-center justify-content-center" style="padding: 10px;padding-left: 29px!important; border-radius: 5px; width: 100%;">
                                                                <label for="securityAmount" class="sr-only">Advance Amount:</label>
                                                                <input type="number" class="form-control border" id="securityAmount" value="500" step="1" style="width: 80%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-12" style="padding-top: 7px!important;">
                                                                <button type="button" class="btn btn-primary btn-sm mt-2">Submit</button>
                                                            </div>
                                                        </div>
                                                                                                                             
                                                    </div>
                                                    <div class="row mt-6" style="margin-top: 80px;">
                                                        <div class="col-md-6" >
                                                            <label for="total_amount" class="text medium fw-bold d-flex" style="margin-left: 50px;padding-top: 5px;">Total Amount</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" value="500" disabled>
                                                        </div>
                                                      
                                                    </div>
                                               
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                     </div>


                     <div class="col-md-4" style="padding-top: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body" style="padding: 0px 0px !important">
                                               
                                            </div>
                                          </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text medium fw-bold mb-2">Customer Details</div>
                                        <div class="row customer-details mt-2" style="border-radius: 5px;">
                                            <div class="col-md-10">
                                                <div class="customer-info" style="padding: 10px; border-radius: 5px;">
                                                    <p style="margin: 0;">John Doe</p>
                                                    <p style="margin: 0;"> john@example.com,(123) 456-7890</p>
                                                    <p style="margin: 0;">XXXXXXXXXXXXXX </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                <input class="form-check-input" type="radio" name="customerType" id="regularCustomer" checked>
                                            </div>
                                        </div>
                                        <div class="text small fw-bold mt-2 mb-2">Summary</div>
                                        <table class="table table-borderless table-striped table-sm">
                                            <tr>
                                                <th>No Of Rooms</th>
                                                <th>:</th>
                                                <th class="text-end">{{ count($rentout_rooms) }}</th>
                                            </tr>
                                            <tr>
                                                <th>No Of Days</th>
                                                <th>:</th>
                                                <th class="text-end">{{ $rentouts['days'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Extra Beds ({{ currency($rentouts['single_extra_bed_charge']) }})</th>
                                                <th>:</th>
                                                <th class="text-end">{{ currency($rentouts['extra_bed_charge']) }}</th>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th>:</th>
                                                <th class="text-end">{{ currency($rentouts['total']) }}</th>
                                            </tr>
                                            <tr>
                                                <th>Tax ({{ percentage($rentouts['tax_percentage']) }}) </th>
                                                <th>:</th>
                                                <th class="text-end">{{ currency($rentouts['tax']) }}</th>
                                            </tr>
                                            <tr>
                                                <th>Coupon Discount</th>
                                                <th>:</th>
                                                <th class="text-end">{{ currency($rentouts['discount_amount']) }}</th>
                                            </tr>
                                            <tr>
                                                <th>Grand Total</th>
                                                <th>:</th>
                                                <th class="text-end">{{ currency($rentouts['grand_total']) }}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                     </div>


                     <div class="col-md-8" style="padding-top: 20px;">
                        
                     </div>


                 </div>
             </div>


            {{-- @if(\Permissions::Allow('Booking.Discount'))
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="text-light small fw-semibold">Discount Details</div>
                        <table class="table table-sm table-bordered table-striped">
                            <tr>
                                <th colspan="2">
                                    {{ Form::label('coupon_code','Coupon Code',['class'=>'form-label']) }}
                                    {{ Form::text('coupon_code','',['wire:model'=>'rentouts.coupon_code','class'=>'form-control','placeholder'=>'Please Enter Coupon Code']) }}
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    {{ Form::label('discount_percentage','Discount %',['class'=>'form-label']) }}
                                    {{ Form::number('discount_percentage','',['wire:model'=>'rentouts.discount_percentage','min'=>0,'max'=>100,'class'=>'form-control','placeholder'=>'Please Enter Discount %']) }}
                                </th>
                                <th>
                                    {{ Form::label('discount_amount','Discount',['class'=>'form-label']) }}
                                    {{ Form::number('discount_amount','',['wire:model'=>'rentouts.discount_amount','class'=>'form-control','readonly','placeholder'=>'Please Enter Discount Amount']) }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    {{ Form::label('discount_reason','Discount Reason',['class'=>'form-label']) }}
                                    {{ Form::text('discount_reason','',['wire:model'=>'rentouts.discount_reason','class'=>'form-control','placeholder'=>'Please Enter Discount Reason']) }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="text-light small fw-semibold">Billing Details</div>
                        <table class="table table-bordered table-striped table-sm">
                            <tr>
                                <th>No Of Rooms</th>
                                <th class="text-end">{{ count($rentout_rooms) }}</th>
                            </tr>
                            <tr>
                                <th>No Of Days</th>
                                <th class="text-end">{{ $rentouts['days'] }}</th>
                            </tr>
                            <tr>
                                <th>Extra Beds ({{ currency($rentouts['single_extra_bed_charge']) }})</th>
                                <th class="text-end">{{ currency($rentouts['extra_bed_charge']) }}</th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th class="text-end">{{ currency($rentouts['total']) }}</th>
                            </tr>
                            <tr>
                                <th>Tax ({{ percentage($rentouts['tax_percentage']) }}) </th>
                                <th class="text-end">{{ currency($rentouts['tax']) }}</th>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <th class="text-end">{{ currency($rentouts['discount_amount']) }}</th>
                            </tr>
                            <tr>
                                <th>Grand Total</th>
                                <th class="text-end">{{ currency($rentouts['grand_total']) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if(\Permissions::Allow('Booking.Security deposit'))
                        <div class="text-light small fw-semibold">Security Deposite</div>
                        <table class="table table-sm table-bordered table-striped">
                            <tr>
                                <th wire:ignore>
                                    {{ Form::label('security_deposit_payment_mode','Payment Mode',['class'=>'form-label']) }}
                                    {{ Form::select('security_deposit_payment_mode',$PaymentModes,'Direct Payment',['wire:model'=>'rentouts.security_deposit_payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'security_deposit_payment_mode']) }}</td>
                                <th>
                                    {{ Form::label('security_amount','Security Amt',['class'=>'form-label']) }}
                                    {{ Form::number('security_amount','',['wire:model'=>'rentouts.security_amount','min'=>0,'class'=>'form-control','placeholder'=>'Please add Security Deposite']) }}
                                </th>
                            </tr>
                        </table>
                        @endif
                        <div class="text-light small fw-semibold">Advance Details</div>
                        <table class="table table-sm table-bordered table-striped">
                            <tr>
                                <th wire:ignore>
                                    {{ Form::label('payment_mode','Payment Mode',['class'=>'form-label']) }}
                                    {{ Form::select('payment_mode',$PaymentModes,'Direct Payment',['wire:model'=>'rentouts.payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'payment_mode']) }}</td>
                                <th>
                                    {{ Form::label('advance_amount','Advance Amt',['class'=>'form-label']) }}
                                    {{ Form::number('advance_amount','',['wire:model'=>'rentouts.advance_amount','min'=>0,'class'=>'form-control','placeholder'=>'Please Enter Advance Amount']) }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    {{ Form::label('advance_reason','Advance Remarks',['class'=>'form-label']) }}
                                    {{ Form::text('advance_reason','',['wire:model'=>'rentouts.advance_reason','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Advance Reason']) }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="card mb-2">
            <div class="card-header sticky-element d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                <h5 class="card-title mb-sm-0">
                    @if($rentouts['status'])
                    Status : {{ $rentouts['status'] }}
                    @endif <br>
                </h5>
                <div class="action-btns">
                    @if(isset($rentouts['id']))
                    <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingContractPrint',$rentouts['id']) }}"> Booking Contract Print </a>
                    <a type="button" class="btn btn-label-info" target="_blank" href="{{ route('Rentout::bookingSummaryPrint',$rentouts['id']) }}"> Booking Summary Print </a>
                    @endif
                    @if(!$rentouts['status'])
                    @if(\Permissions::Allow('Booking.Create'))
                    <button type="button" class="btn btn-label-info" wire:click="save('{{ Rentout::Pending }}')"> <span class="align-middle"> Booking</span> </button>
                    @endif
                    @if(\Permissions::Allow('Checkin.Create'))
                    <button type="button" class="btn btn-primary" wire:click="save('{{ Rentout::CheckIn }}')">Check In</button>
                    @endif
                    @else
                    @switch($rentouts['status'])
                    @case(Rentout::Booked)
                        @if($rentouts['status']==Rentout::Booked)
                            @if(\Permissions::Allow('Checkin.Create'))
                            <button type="button" class="btn btn-primary" wire:click="save('{{ Rentout::CheckIn }}')">Check In</button> &nbsp; &nbsp; &nbsp; &nbsp;
                            @endif
                        @endif
                    @break
                    @case(Rentout::Pending)
                    @break
                    @case(Rentout::Rejected)
                    @break
                    @case(Rentout::CheckIn)
                    @break
                    @case(Rentout::CheckOut)
                    @break
                    @case(Rentout::Cancelled)
                    @break
                    @endswitch
                        @if(\Permissions::Allow('Booking.Edit') || \Permissions::Allow('Checkin.Edit'))
                            <button type="button" class="btn btn-label-info" wire:click="save('{{ $rentouts['status'] }}')"> <span class="align-middle"> Save</span> </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </form>
    @section('script')
    @parent
<script type="text/javascript">

        $(document).ready(function () {

            main_check_in_date = $('#main_check_in_date').flatpickr({
                enableTime: true,
                dateFormat: 'd-m-Y H:i',
                disable: [
                    {
                        from: "{{ date('d-m-Y',strtotime('-10 years')) }}",
                        to: "{{ date('d-m-Y',strtotime('-1 days')) }}"
                    }
                ]
            });
            main_check_out_date = $('#main_check_out_date').flatpickr({
                enableTime: true,
                dateFormat: 'd-m-Y H:i',
                disable: [
                    {
                        from: "{{ date('d-m-Y',strtotime('-10 years')) }}",
                        to: "{{ date('d-m-Y',strtotime('-1 days')) }}"
                    }
                ]
            });
            $('#main_check_in_date').on('change', function (e) {
                @this.set('rentouts.check_in_date', $(this).val());
            });
            $('#security_deposit_payment_mode').change();
            $('#security_deposit_payment_mode').on('change', function (e) {
                @this.set('rentouts.security_deposit_payment_mode', $(this).val());
            });
            $('#payment_mode').change();
            $('#payment_mode').on('change', function (e) {
                @this.set('rentouts.payment_mode', $(this).val());
            });
            $('#main_check_out_date').on('change', function (e) {
                @this.set('rentouts.check_out_date', $(this).val());
                $('#arrival_from').select();
            });
            window.addEventListener('main_check_out_date_change', event => {
                main_check_out_date.setDate($('#main_check_out_date').val(), false);
            });
            window.addEventListener('main_check_in_date_change', event => {
                main_check_in_date.setDate($('#main_check_in_date').val(), false);
            });
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
            $('#agent_id').change();
            $('#agent_id').on('select2:select change', function (e) {
                @this.set('rentouts.agent_id', $(this).val());
            });
            $('#customer_id').on('select2:select change', function (e) {
                @this.set('customer_id', $(this).val());
            });
            $('#customer_id').on("select2:select change", function (e) {
                if ($(this).val() == 'Add') {
                    $('#customer_id').val(null).change();
                    window.livewire.emit("CreateCustomer", 'customer_id');
                    $("#CustomerModal").modal("show");
                }
            });
            $('#type').on('select2:select change', function (e) {
                $('#room_id').select2('open');
            });
            window.addEventListener('AppendNewCustomerToDataTable', event => {
                @this.set('customer_id', event.detail.id);
                window.livewire.emit("AddCustomer");
            });

        });
    </script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
      var radios = document.querySelectorAll('input[name="paymentMethod"]');
      var advanceRadios = document.querySelectorAll('input[name="advancePaymentMethod"]');
      var referenceFields = document.querySelectorAll('.referenceFields');
      var advanceReferenceFields = document.querySelectorAll('.advanceReferenceFields');

      function toggleReferenceNumberFields(element) {
          var referenceId = element.dataset.reference;
          var currentReferenceField = document.getElementById(referenceId);

          referenceFields.forEach(function (field) {
              if (field !== currentReferenceField) {
                  field.style.display = "none";
              }
          });

          if (currentReferenceField) {
              currentReferenceField.style.display = "block";
          }
      }

      function toggleAdvanceReferenceNumberFields(element) {
          var referenceId = element.dataset.reference;
          var currentReferenceField = document.getElementById(referenceId);

          advanceReferenceFields.forEach(function (field) {
              if (field !== currentReferenceField) {
                  field.style.display = "none";
              }
          });

          if (currentReferenceField) {
              currentReferenceField.style.display = "block";
          }
      }

      radios.forEach(function (radio) {
          radio.addEventListener("change", function () {
              toggleReferenceNumberFields(radio);
          });

          toggleReferenceNumberFields(radio);
      });

      advanceRadios.forEach(function (radio) {
          radio.addEventListener("change", function () {
              toggleAdvanceReferenceNumberFields(radio);
          });

          toggleAdvanceReferenceNumberFields(radio);
      });
  });

    </script>

    @if(in_Array($rentouts['status'],[Rentout::CheckOut,Rentout::Cancelled]))
    <script>
        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('#main_check_in_date').attr('disabled', true);
        $('#main_check_out_date').attr('disabled', true);
    </script>
    @endif
    @stop
</div>
