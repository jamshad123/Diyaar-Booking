<nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
    @livewire('admin.global.building-change')
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @if(\Permissions::Allow('DayCollection'))
            <li class="nav-item me-2 me-xl-0 ot-btn">
                <a class="nav-link hide-arrow day-btn day-btn-open" href="javascript:void(0);">
                    <button type="button" data-bs-target="#DayOpenModal" data-bs-toggle="modal" class="btn btn-info day-open" name="button">Day Open</button>
                </a>
            </li>
            <li class="nav-item me-2 me-xl-0 ot-btn">
                <a class="nav-link hide-arrow day-btn" href="javascript:void(0);">
                    <button type="button" data-bs-target="#DayCloseModal" data-bs-toggle="modal" class="btn btn-secondary day-close" name="button">Day Close</button>
                </a>
            </li>
            @endif
            <li class="nav-item me-2 me-xl-0 day-btn time-view ot-btn">
                @livewire('general.clock')
            </li>
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0" hidden>
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="fi fi-us fis rounded-circle fs-3 me-1"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                            <i class="fi fi-us fis rounded-circle fs-4 me-1"></i>
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item me-2 me-xl-0">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="bx bx-sm"></i>
                </a>
            </li>
            <li>
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bx bx-cog bx-sm"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Settings</h5>
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="bx bx-sm bx-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            @if(\Permissions::Allow('Building.Read','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-building fs-4"></i>
                                </span>
                                <a href="{{ route('Building::List') }}" class="stretched-link">Building</a>
                                <small class="text-muted mb-0">Manage Buildings</small>
                            </div>
                            @endif
                            @if(\Permissions::Allow('Room.Read','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-building fs-4"></i>
                                </span>
                                <a href="{{ route('Building::Room::List') }}" class="stretched-link">Room</a>
                                <small class="text-muted mb-0">Manage Rooms</small>
                            </div>
                            @endif
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            @if(\Permissions::Allow('Customer.Read','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-user fs-4"></i>
                                </span>
                                <a href="{{ route('Customer::List') }}" class="stretched-link">Customer</a>
                                <small class="text-muted mb-0">Manage Customers</small>
                            </div>
                            @endif
                            @if(\Permissions::Allow('Agent.Read','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-user fs-4"></i>
                                </span>
                                <a href="{{ route('Agent::List') }}" class="stretched-link">Agent</a>
                                <small class="text-muted mb-0">Manage Agents</small>
                            </div>
                            @endif
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            @if(\Permissions::Allow('Settings','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-cog fs-4"></i>
                                </span>
                                <a href="{{ route('settings::page') }}" class="stretched-link">Settings</a>
                                <small class="text-muted mb-0">Account Settings</small>
                            </div>
                            @endif
                            @if(\Permissions::Allow('Role.Read','Read'))
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-cog fs-4"></i>
                                </span>
                                <a href="{{ route('roles::page') }}" class="stretched-link">Roles</a>
                                <small class="text-muted mb-0">Roles</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0" hidden>
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bx bx-grid-alt bx-sm"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="bx bx-sm bx-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-calendar fs-4"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                <small class="text-muted mb-0">Appointments</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-food-menu fs-4"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                <small class="text-muted mb-0">Manage Accounts</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-user fs-4"></i>
                                </span>
                                <a href="app-user-list.html" class="stretched-link">User App</a>
                                <small class="text-muted mb-0">Manage Users</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-check-shield fs-4"></i>
                                </span>
                                <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                <small class="text-muted mb-0">Permission</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-pie-chart-alt-2 fs-4"></i>
                                </span>
                                <a href="{{ url('/') }}" class="stretched-link">Dashboard</a>
                                <small class="text-muted mb-0">User Profile</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-cog fs-4"></i>
                                </span>
                                <a href="{{ route('settings::page') }}" class="stretched-link">Setting</a>
                                <small class="text-muted mb-0">Account Settings</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-help-circle fs-4"></i>
                                </span>
                                <a href="pages-help-center-landing.html" class="stretched-link">Help Center</a>
                                <small class="text-muted mb-0">FAQs & Articles</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-window-open fs-4"></i>
                                </span>
                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                <small class="text-muted mb-0">Useful Popups</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1" hidden>
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bx bx-bell bx-sm"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Notification</h5>
                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read">
                                <i class="bx fs-4 bx-envelope-open"></i>
                            </a>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                                        <p class="mb-0">Won the monthly best seller gold badge</p>
                                        <small class="text-muted">1h ago</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">New Message ✉️</h6>
                                        <p class="mb-0">You have new message from Natalie</p>
                                        <small class="text-muted">1h ago</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-menu-footer border-top">
                        <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
                            View all notifications
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('User::View',Auth::id()) }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"> {{ Auth::user()->name }} </span>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
    </div>
</nav>