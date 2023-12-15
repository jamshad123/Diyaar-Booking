<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Room Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <table class="table table-bordered table-light table-striped">
                            @if($Room)
                            <tr>
                                <th width="70%">Booking Status</th>
                                <td>{{ $Room['booking_status'] }}</td>
                            </tr>
                            @if(\Permissions::Allow('Room.Maintenance'))
                            <tr>
                                <th width="70%">Room Maintenance Status</th>
                                <td>
                                    <button type="button" wire:click="ChangeMaintenanceStatus" class="btn btn-sm @if($Room->status=="Maintenance") btn-danger @else btn-success @endif">@if($Room->status=="Maintenance") Yes @else No @endif</button>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <th width="70%">Room Maintenance Status</th>
                                <td> @if($Room->status=="Maintenance") True @else False @endif </td>
                            </tr>
                            @endif
                            @if(\Permissions::Allow('Room.Inactive'))
                            <tr>
                                <th width="70%">Room Active Status</th>
                                <td>
                                    <button type="button" wire:click="ChangeActiveStatus" class="btn btn-sm @if($Room->status=="InActive") btn-warning @else btn-success @endif">@if($Room->status=="InActive") No @else Yes @endif</button>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <th width="70%">Room Active Status</th>
                                <td> @if($Room->status=="Active") Active @else In Active @endif </td>
                            </tr>
                            @endif
                            <tr>
                                <th width="70%">Room Type</th>
                                <td>{{ $Room->type }}</td>
                            </tr>
                            @if(\Permissions::Allow('Room.Hygiene Status'))
                            <tr>
                                <th width="70%">Hygiene Status</th>
                                <td>
                                    <button type="button" wire:click="ChangeHygieneStatus" class="btn btn-sm @if($Room->hygiene_status=="Dirty") btn-danger @else btn-success @endif">{{ $Room->hygiene_status }}</button>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <th width="70%">Hygiene Status</th>
                                <td> {{ $Room->hygiene_status }} </td>
                            </tr>
                            @endif
                            <tr>
                                <th width="70%">No Of Beds</th>
                                <td>{{ $Room->no_of_beds }}</td>
                            </tr>
                            <tr>
                                <th width="70%">capacity</th>
                                <td>{{ $Room->capacity }}</td>
                            </tr>
                            <tr>
                                <th width="70%">extra capacity</th>
                                <td>{{ $Room->extra_capacity }}</td>
                            </tr>
                            <tr>
                                <th width="70%">floor</th>
                                <td>{{ $Room->floor }}</td>
                            </tr>
                            @if(!$RentoutRoom)
                            <tr>
                                <th width="70%">Rent/ Day</th>
                                <td>{{ currency($Room->amount) }}</td>
                            </tr>
                            @if($Room->description)
                            <tr>
                                <td colspan="2">
                                    <p>Description</p>
                                    {{ $Room->description }}
                                </td>
                            </tr>
                            @endif
                            @if($Room->reserve_condition)
                            <tr>
                                <td colspan="2">
                                    <p>Reserve Condition</p>
                                    {{ $Room->reserve_condition }}
                                </td>
                            </tr>
                            @endif
                            @else
                            @if($RentoutRoom->customer)
                            <tr>
                                <th width="70%">Customer Name</th>
                                <td>{{ $RentoutRoom->customer->full_name }}</td>
                            </tr>
                            <tr>
                                <th width="70%">Customer Mobile</th>
                                <td>{{ $RentoutRoom->customer->mobile }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th width="70%">Check In</th>
                                <td>{{ systemDate($RentoutRoom->check_in_date) }}</td>
                            </tr>
                            <tr>
                                <th width="70%">Check Out</th>
                                <td>{{ systemDate($RentoutRoom->check_in_date) }}</td>
                            </tr>
                            <tr>
                                <th width="70%">Rent</th>
                                <td>{{ $RentoutRoom->amount }}</td>
                            </tr>
                            @if($RentoutRoom->rentout)
                            <tr>
                                <th width="70%">Paid Amount</th>
                                <td>{{ currency($RentoutRoom->rentout->paid) }}</td>
                            </tr>
                            <tr>
                                <th width="70%">Due Amount</th>
                                <td>{{ currency($RentoutRoom->rentout->balance) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th width="70%" colspan="2">Customer Address</th>
                            </tr>
                            @if($RentoutRoom->customer)
                            <tr>
                                <td colspan="2">{!! $RentoutRoom->customer->address !!}</td>
                            </tr>
                            @endif
                            @endif
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            @if(!$RentoutRoom)
            @if($Room)
            @if(!in_array($Room['status'],['Maintenance','InActive']))
            @if(\Permissions::Allow('Booking.Create'))
            <button type="button" wire:click="BookNow" class="btn btn-primary">Book Now</button>
            @endif
            @endif
            @endif
            @else
            @if($RentoutRoom['status']=="Pending")
            @if(\Permissions::Allow('BookedPending.Approve'))
            <a href="{{ route('Rentout::pending',$RentoutRoom->rentout_id) }}" class="btn btn-primary">View {{ $RentoutRoom['status'] }} </a>
            @endif
            @else
            @if(\Permissions::Allow('Booking.View'))
            <a href="{{ route('Rentout::view',$RentoutRoom->rentout_id) }}" class="btn btn-primary">View {{ $RentoutRoom['status'] }} </a>
            @endif
            @endif
            @endif
        </div>
    </form>
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () { });
    </script>
    @stop
</div>