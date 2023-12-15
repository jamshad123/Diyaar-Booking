<div class="row">
    @if(\Permissions::Allow('Dashboard.Today Booking'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/booking.png') }}" alt="today booking" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">today booking</span>
                <h3 class="card-title text-nowrap mb-1">{{ $today_booking_count }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Today Checkin'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/check-in.png') }}" alt="total checkin" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">Today checkin</span>
                <h3 class="card-title text-nowrap mb-1">{{ $today_check_in_count??0 }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Total Customer'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/total-customer.png') }}" alt="total customer" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">total customer</span>
                <h3 class="card-title text-nowrap mb-1">{{ $total_customer }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Total Amount'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/total-amount.png') }}" alt="total amount" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">total amount</span>
                <h3 class="card-title text-nowrap mb-1">{{ currency($total_amount) }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Available Rooms'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/check-in.png') }}" alt="total checkin" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">Available Rooms</span>
                <h3 class="card-title text-nowrap mb-1">{{ $today_available_rooms??0 }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Dirty Rooms'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/check-in.png') }}" alt="total checkin" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">Dirty Rooms</span>
                <h3 class="card-title text-nowrap mb-1">{{ $dirty_rooms??0 }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Buildings'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1" hidden>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/total-booking.png') }}" alt="total booking" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">total booking</span>
                <h3 class="card-title text-nowrap mb-1">{{ $total_booking_count }}</h3>
            </div>
        </div>
    </div>
    @endif
    @if(\Permissions::Allow('Dashboard.Buildings'))
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 order-1" hidden>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/img/icons/dashbord/avilabile-room.png') }}" alt="availble room" class="rounded" />
                    </div>
                </div>
                <span class="text-capitalize">availble room for today</span>
                <h3 class="card-title text-nowrap mb-1">{{ $today_available_rooms }}</h3>
            </div>
        </div>
    </div>
    @endif
</div>