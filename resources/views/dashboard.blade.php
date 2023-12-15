<?php use App\Models\Room; ?>
@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.dashboard.count')
    <div class="row">
        <!-- Bar Chart -->
        @if(\Permissions::Allow('Dashboard.Buildings'))
        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
                    <h5 class="card-title mb-0">Building - [{{ systemDate(date('Y-m-d')) }}] </h5>
                </div>
                <div class="card-body">
                    <div id="buildingChart"></div>
                </div>
            </div>
        </div>
        @endif
        <!-- /Bar Chart -->
        <!-- Total Revenue -->
        <div hidden class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-xl-10 col-lg-8 col-md-8">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Total Income</h5>
                            <small class="card-subtitle">Yearly report overview</small>
                        </div>
                        <div class="card-body">
                            <div id="totalIncomeChart"></div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Report</h5>
                                <small class="card-subtitle">Monthly Avg. $45.578k</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="totalIncome" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalIncome">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="report-list">
                                <table class="table table-sm table-light table-striped">
                                    <thead>
                                        <th>Month</th>
                                        <th class="text-end">Income</th>
                                    </thead>
                                    <tbody>
                                        <?php $months= [''] ?>
                                        <?php for ($i=1; $i <=7 ; $i++): ?>
                                        <tr>
                                            <td>{{ date('M',strtotime("-$i month")) }}</td>
                                            <td class="text-end">{{ currency(rand(100,20000)) }}</td>
                                        </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Income -->
        </div>
    </div>
    <div class="row">
        <!-- Order Statistics -->
        <div hidden class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Booking History</h5>
                        <small class="text-muted">42.82k Total Sales</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">8,258</h2>
                            <span>Total Orders</span>
                        </div>
                        <div id="BookingHistoryChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Check In</h6>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">82.5k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Check Out</h6>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">23.8k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Pending</h6>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">849k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Cancelled</h6>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">99</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->
        <!-- Transactions -->
        <div hidden class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Last 5 Transactions</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/paypal.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Paypal</small>
                                    <h6 class="mb-0">Customer Paid </h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+82.6</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Mac'D</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+270.69</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Transfer</small>
                                    <h6 class="mb-0">Refund</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+637.91</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/cc-success.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Credit Card</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-838.71</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Starbucks</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+203.33</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/icons/unicons/cc-warning.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Mastercard</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-92.45</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
        <!-- Activity Timeline -->
        <div hidden class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Today CheckOut List</h5>
                </div>
                <div class="card-body">
                    <!-- Activity Timeline -->
                    <div style="overflow-y: scroll;  height: 400px;">
                        <ul class="timeline">
                            <?php for ($i=0; $i <5 ; $i++) :?>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Room No {{$i+1}} is going to check out today</h6>
                                        <small class="text-muted">12 min ago</small>
                                    </div>
                                    <div class="d-flex">
                                        <a href="javascript:void(0)" class="d-flex align-items-center me-3">
                                            <img src="{{ asset('assets/img/icons/misc/pdf.png') }}" alt="PDF image" width="23" class="me-2" />
                                            <h6 class="mb-0">invoices.pdf</h6>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <?php endfor ?>
                            <li class="timeline-end-indicator">
                                <i class="bx bx-check-circle"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /Activity Timeline -->
                </div>
            </div>
        </div>
        <!--/ Activity Timeline -->
        <!-- pill table -->
        @if(\Permissions::Allow('Dashboard.Today Booking List'))
        <div class="col-md-6 order-3 order-lg-6 mb-4 mb-lg-0">
            <div class="card text-center">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Today Booking List</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('admin.dashboard.booking-list',['date'=>date('Y-m-d')])
                </div>
            </div>
        </div>
        @endif
        @if(\Permissions::Allow('Dashboard.Next Day Booking List'))
        <div class="col-md-6 order-3 order-lg-6 mb-4 mb-lg-0">
            <div class="card text-center">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Next Day Booking List</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('admin.dashboard.booking-list',['date'=>date('Y-m-d',strtotime('+1 day'))])
                </div>
            </div>
        </div>
        @endif
        <!--/ pill table -->
    </div>
</div>
@endsection
@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
<script>
    OccupiedData = [];
    VacantData = [];
    MaintenanceData = [];
    categories = [];
    @foreach($list as $building_name => $building)
    OccupiedData.push('{{ $building[Room::Occupied] }}');
    VacantData.push('{{ $building[Room::Vacant] }}');
    MaintenanceData.push('{{ $building[Room::Maintenance] }}');
    categories.push('{{ $building_name }}');
    @endforeach
</script>
<script type="text/javascript">
        var options = {
            series: [{
                name: '{{ Room::Occupied }}',
                data: OccupiedData,
            }, {
                name: '{{ Room::Vacant }}',
                data: VacantData,
            }, {
                name: '{{ Room::Maintenance }}',
                data: MaintenanceData,
            },
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                labels: {
                    rotate: -45
                },
                categories: categories,
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " rooms"
                    }
                }
            }
        };
    var chart = new ApexCharts(document.querySelector("#buildingChart"), options);
    chart.render();
    let cardColor, headingColor, legendColor, labelColor;
    if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        labelColor = config.colors_dark.textMuted;
        legendColor = config.colors_dark.bodyColor;
        headingColor = config.colors_dark.headingColor;
    } else {
        cardColor = config.colors.cardColor;
        labelColor = config.colors.textMuted;
        legendColor = config.colors.bodyColor;
        headingColor = config.colors.headingColor;
    }
    // --------------------------------------------------------------------
    const BookingHistoryChart = document.querySelector('#BookingHistoryChart'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['Check In', 'Check Out', 'Pending', 'Cancelled'],
            series: [85, 15, 50, 50],
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '%';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '%';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: legendColor,
                                label: 'Weekly',
                                formatter: function (w) {
                                    return '38%';
                                }
                            }
                        }
                    }
                }
            },
            states: {
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };
    if (typeof BookingHistoryChart !== undefined && BookingHistoryChart !== null) {
        const statisticsChart = new ApexCharts(BookingHistoryChart, orderChartConfig);
        statisticsChart.render();
    }
    let shadeColor, borderColor, heatMap1, heatMap2, heatMap3, heatMap4;
    if (isDarkStyle) {
        borderColor = config.colors_dark.borderColor;
        shadeColor = 'dark';
        heatMap1 = '#4f51c0';
        heatMap2 = '#595cd9';
        heatMap3 = '#8789ff';
        heatMap4 = '#c3c4ff';
    } else {
        borderColor = config.colors.borderColor;
        shadeColor = '';
        heatMap1 = '#e1e2ff';
        heatMap2 = '#c3c4ff';
        heatMap3 = '#a5a7ff';
        heatMap4 = '#696cff';
    }
    // Total Income - Area Chart
    // --------------------------------------------------------------------
    const totalIncomeEl = document.querySelector('#totalIncomeChart'),
        totalIncomeConfig = {
            chart: {
                height: 250,
                type: 'area',
                toolbar: false,
                dropShadow: {
                    enabled: true,
                    top: 14,
                    left: 2,
                    blur: 3,
                    color: config.colors.primary,
                    opacity: 0.15
                }
            },
            series: [
                {
                    data: [3350, 3350, 4800, 4800, 2950, 2950, 1800, 1800, 3750, 3750, 5700, 5700]
                }
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 3,
                curve: 'straight'
            },
            colors: [config.colors.primary],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: shadeColor,
                    shadeIntensity: 0.8,
                    opacityFrom: 0.7,
                    opacityTo: 0.25,
                    stops: [0, 95, 100]
                }
            },
            grid: {
                show: true,
                borderColor: borderColor,
                padding: {
                    top: -15,
                    bottom: -10,
                    left: 0,
                    right: 0
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    offsetX: 0,
                    style: {
                        colors: labelColor,
                        fontSize: '13px'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                lines: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    offsetX: -15,
                    formatter: function (val) {
                        return '$' + parseInt(val / 1000) + 'k';
                    },
                    style: {
                        fontSize: '13px',
                        colors: labelColor
                    }
                },
                min: 1000,
                max: 6000,
                tickAmount: 5
            }
        };
    if (typeof totalIncomeEl !== undefined && totalIncomeEl !== null) {
        const totalIncome = new ApexCharts(totalIncomeEl, totalIncomeConfig);
        totalIncome.render();
    }
</script>
@endsection