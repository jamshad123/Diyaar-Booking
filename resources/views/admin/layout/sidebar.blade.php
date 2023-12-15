<?php use App\Models\Rentout; ?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo fixed-logo-bar">
        <a href="{{ url('/') }}" class="app-brand-link sidebar-logo">
            <img src="{{ asset('logo.png') }}" width="100%" alt="">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Diyar</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ (request()->is(['/'])) ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="menu-link {{ (request()->is('/')) ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        @if(\Permissions::Allow('Collection'))
        <li class="menu-item {{ (request()->is(['Collection'])) ? 'active' : '' }}">
            <a href="{{ url('Collection') }}" class="menu-link {{ (request()->is('Collection')) ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Collection">Collection</div>
            </a>
        </li>
        @endif
        @if(\Permissions::Allow('Offer.Read'))
        <li class="menu-item {{ (request()->is(['offers/list'])) ? 'active' : '' }}">
            <a href="{{ route('offers::list') }}" class="menu-link {{ (request()->is('offers/list')) ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Offer">Offer</div>
            </a>
        </li>
        @endif
        @if(\Permissions::Allow('Customer.Read'))
        <li class="menu-item {{ (request()->is(['Customer/List'])) ? 'active' : '' }}">
            <a href="{{ route('Customer::List') }}" class="menu-link {{ (request()->is('Customer/List')) ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Customers">Customers</div>
            </a>
        </li>
        @endif
        @if(\Permissions::Allow('Coupon.Read'))
        <li class="menu-item {{ (request()->is(['coupons/list'])) ? 'active' : '' }}">
            <a href="{{ route('coupons::list') }}" class="menu-link {{ (request()->is('coupons/list')) ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Coupons">Coupons</div>
            </a>
        </li>
        @endif
        @if(\Permissions::Allow('Role.Read'))
        <li class="menu-item {{ (request()->is(['roles'])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div data-i18n="Roles &amp; Permissions">Roles &amp; Permissions</div>
            </a>
            <ul class="menu-sub">
                @if(\Permissions::Allow('Role.Read'))
                <li class="menu-item {{ (request()->is(['roles'])) ? 'active' : '' }}">
                    <a href="{{ route('roles::page') }}" class="menu-link">
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(\Permissions::AllowModule('Reservation'))
        <li class="menu-item {{ (request()->is(['Rentout/create','Rentout/edit/*','Rentout/List/*','Rentout/checkout','Rentout/checkout/*'])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Room Reservation">Room Reservation</div>
            </a>
            <ul class="menu-sub">
                @if(\Permissions::Allow('Booking.Create') || \Permissions::Allow('Booking.View') || \Permissions::Allow('Booking.Edit'))
                <li class="menu-item {{ (request()->is(['Rentout/create','Rentout/edit/*'])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::create') }}" class="menu-link">
                        <div data-i18n="Reservation">Reservation</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Booking.List'))
                <li class="menu-item {{ (request()->is(['Rentout/List/'.Rentout::Booked])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::List',Rentout::Booked) }}" class="menu-link">
                        <div data-i18n="Booking List">Booking List</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('BookedPending.list'))
                <li class="menu-item {{ (request()->is(['Rentout/List/'.Rentout::Pending])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::List',['status'=>Rentout::Pending]) }}" class="menu-link">
                        <div data-i18n="Pending Booking">Pending Booking</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Checkin.List'))
                <li class="menu-item {{ (request()->is(['Rentout/List/'.Rentout::CheckIn])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::List',Rentout::CheckIn) }}" class="menu-link">
                        <div data-i18n="Check In List">Check In List</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Checkout.Create'))
                <li class="menu-item {{ (request()->is(['Rentout/checkout','Rentout/checkout/*'])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::checkout::page') }}" class="menu-link">
                        <div data-i18n="Check Out">Check Out</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(\Permissions::AllowModule('Report'))
        <li class="menu-item {{ (request()->is(['Rentout/List','Rentout/checkout-report','report/payment'])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Report">Report</div>
            </a>
            <ul class="menu-sub">
                @if(\Permissions::Allow('Checkout Report'))
                <li class="menu-item {{ (request()->is(['Rentout/checkout-report'])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::bills') }}" class="menu-link">
                        <div data-i18n="Checkout Report">Checkout Report</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Reservation Report'))
                <li class="menu-item {{ (request()->is(['Rentout/List'])) ? 'active' : '' }}">
                    <a href="{{ route('Rentout::List') }}" class="menu-link">
                        <div data-i18n="Reservation List">Reservation List</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Payment Report'))
                <li class="menu-item {{ (request()->is(['report/payment'])) ? 'active' : '' }}">
                    <a href="{{ route('report::payment::page') }}" class="menu-link">
                        <div data-i18n="Payment Report">Payment Report</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(\Permissions::Allow('Room.Read') ||\Permissions::Allow('Room Status.Table View') || \Permissions::Allow('Room Status.Grid View') || \Permissions::Allow('Room Plan'))
        <li class="menu-item {{ (request()->is(['Building/Room/List','Building/Room/Status','Building/Room/Plan'])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Rooms">Rooms</div>
            </a>
            <ul class="menu-sub">
                @if(\Permissions::Allow('Room.Read'))
                <li class="menu-item {{ (request()->is(['Building/Room/List'])) ? 'active' : '' }}">
                    <a href="{{ route('Building::Room::List') }}" class="menu-link">
                        <div data-i18n="Room List">Room List</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Room Status.Table View') || \Permissions::Allow('Room Status.Grid View'))
                <li class="menu-item {{ (request()->is(['Building/Room/Status'])) ? 'active' : '' }}">
                    <a href="{{ route('Building::Room::Status::Page') }}" class="menu-link">
                        <div data-i18n="Room Status">Room Status</div>
                    </a>
                </li>
                @endif
                @if(\Permissions::Allow('Room Plan'))
                <li class="menu-item {{ (request()->is(['Building/Room/Plan'])) ? 'active' : '' }}">
                    <a href="{{ route('Building::Room::Plan::Page') }}" class="menu-link">
                        <div data-i18n="Room Plan">Room Plan</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(\Permissions::Allow('User.Read'))
        <li class="menu-item {{ (request()->is(['User/List'])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
                @if(\Permissions::Allow('User.Read'))
                <li class="menu-item {{ (request()->is(['User/List'])) ? 'active' : '' }}">
                    <a href="{{ route('User::List') }}" class="menu-link">
                        <div data-i18n="List">List</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Misc -->
        @if(env('APP_ENV')=='local')
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
        <li class="menu-item">
            <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
            </a>
        </li>
        @endif
    </ul>
</aside>