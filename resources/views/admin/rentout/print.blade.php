<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Invoice</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="invoice-print p-5">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">
                <div class="d-flex svg-illustration mb-3 gap-2">
                    <img width="10%" src="{{ asset('logo.png') }}" alt="">
                </div>
                <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
                <p class="mb-1">San Diego County, CA 91905, USA</p>
                <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
            </div>
            <div>
                <h4>InvoiceNo:#{{ $Self->id }}</h4>
                <div class="mb-2">
                    <span>Date Issues: </span> <br>
                    <span class="fw-semibold"> {{ systemDate($Self->check_in_date) }}</span>
                </div>
                <div>
                    <span>Date Due:</span>
                    <span class="fw-semibold"><br>
                        {{ systemDate($Self->check_out_date) }}</span>
                </div>
            </div>
        </div>
        <hr />
        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-6 w-50">
                <h6>Invoice To:</h6>
                <p class="mb-1">{{ $Self->customer->full_name }}</p>
                <p class="mb-1">{{ $Self->customer->address }}</p>
                <p class="mb-1">{{ $Self->customer->country }}</p>
                <p class="mb-1">{{ $Self->customer->state }}</p>
                <p class="mb-1">{{ $Self->customer->city }}</p>
                <p class="mb-1">{{ $Self->customer->zip_code }}</p>
                <p class="mb-1">{{ $Self->customer->mobile }}</p>
                <p class="mb-1">{{ $Self->customer->email }}</p>
            </div>
            <div class="col-sm-6 w-50">
                <h6>Bill To:</h6>
                <table>
                    <tbody>
                        <tr>
                            <td class="pe-3">Total</td>
                            <td><strong>{{ currency($Self->grand_total) }}</strong></td>
                        </tr>
                        <tr>
                            <td class="pe-3">Paid</td>
                            <td><strong>{{ currency($Self->paid) }}</strong></td>
                        </tr>
                        <tr>
                            <td class="pe-3">Total Due:</td>
                            <td><strong>{{ currency($Self->balance) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table border-top table-striped table-hover">
                <tr>
                    <th>Room Type</th>
                    <td>{{ $Self->rentoutRooms()->join('rooms','rooms.id','room_id')->select(DB::raw('GROUP_CONCAT(rooms.type) as types'))->groupBy('rentout_id')->value('types'); }}</td>
                </tr>
                <tr>
                    <th>Room No</th>
                    <td>{{ $Self->rentoutRooms()->join('rooms','rooms.id','room_id')->select(DB::raw('GROUP_CONCAT(rooms.room_no) as room_nos'))->groupBy('rentout_id')->value('room_nos'); }}</td>
                </tr>
                <tr>
                    <th>Check In</th>
                    <td>{{ systemDate($Self->check_in_date) }}</td>
                </tr>
                <tr>
                    <th>Check Out</th>
                    <td>{{ systemDate($Self->check_out_date) }}</td>
                </tr>
                <tr>
                    <th>Booking Status</th>
                    <td>{{ $Self->status }}</td>
                </tr>
                <tr>
                    <th>No Of Rooms</th>
                    <td>{{ $Self->rentoutRooms->count() }}</td>
                </tr>
                <tr>
                    <th>No Of Adults</th>
                    <td>{{ $Self->rentoutRooms->sum('no_of_adult') }}</td>
                </tr>
                <tr>
                    <th>No Of Nights</th>
                    <td>{{ $Self->roomDates->count() }}</td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table border-top table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th class="text-end">Room No</th>
                        <th>Date</th>
                        <th class="text-end">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Self->roomDates as $key => $value): ?>
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->room->type }}</td>
                        <td class="text-end">{{ $value->room->room_no }}</td>
                        <td>{{ systemDate($value['date']) }}</td>
                        <td class="text-end">{{ currency($value['amount']) }}</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="align-top px-4 py-3">
                            <p class="mb-2">
                                <span class="me-1 fw-semibold">Staff :</span>
                                <span>{{ $Self->creator->name }}</span>
                            </p>
                            <span>Thanks for your business</span>
                        </td>
                        <td colspan="3" class="text-end px-4 py-3">
                            <p class="mb-2">Subtotal:</p>
                            <p class="mb-2">Discount Amount:</p>
                            <p class="mb-2">Tax:</p>
                            <p class="mb-0">Total:</p>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <p class="fw-semibold mb-2">{{ currency($Self->total) }}</p>
                            <p class="fw-semibold mb-2">{{ currency($Self->discount_amount) }}</p>
                            <p class="fw-semibold mb-2">{{ currency(0) }}</p>
                            <p class="fw-semibold mb-2">{{ currency($Self->grand_total) }}</p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-semibold">Note:</span>
                <span>It was a pleasure working with you and your team. Thank You!</span>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Page JS -->
    <script type="text/javascript">
        'use strict';
        (function () { window.print(); })();
    </script>
</body>

</html>