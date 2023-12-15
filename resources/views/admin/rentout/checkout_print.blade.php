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
        <div class="d-flex justify-content-between flex-row" align="Center">
            <div class="mb-4" align="Center">
                <div class="d-flex svg-illustration mb-3 gap-2" align="Center">
                    <img width="10%" align="Center" src="{{ asset('logo.png') }}" alt="">
                </div>
                <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
                <p class="mb-1">San Diego County, CA 91905, USA</p>
                <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
            </div>
        </div>
        <hr />
        <div class="row d-flex justify-content-between mb-4">
        <div class="col-sm-6 w-50">
            <h6>INVOICED FROM:</h6>
            <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
            <p class="mb-1">San Diego County, CA 91905, USA</p>
            <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
        </div>
            <div class="col-sm-6 w-50">
                <h6>Details ofthe Guest:</h6>
                <p class="mb-1">{{ $Self->customer->full_name }}</p>
                <p class="mb-1">{{ $Self->customer->address }}</p>
                <p class="mb-1">{{ $Self->customer->country }}</p>
                <p class="mb-1">{{ $Self->customer->state }}</p>
                <p class="mb-1">{{ $Self->customer->city }}</p>
                <p class="mb-1">{{ $Self->customer->zip_code }}</p>
                <p class="mb-1">{{ $Self->customer->mobile }}</p>
                <p class="mb-1">{{ $Self->customer->email }}</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table border-top  table-sm table-bordered table-striped table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th rowspan="2">Date</th>
                        <th colspan="10" class="text-center">Room Rent Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Self->rentouts as $key => $value): ?>
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
                                            <th class="text-end">Room No</th>
                                            <th class="text-end">No Of Days</th>
                                            <th class="text-end">Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($value->rentoutRooms as $rentoutRoomKey => $rentoutRoomValue): ?>
                                            <tr>
                                                <td class="text-end">{{ $rentoutRoomKey+1 }}</td>
                                                <td class="text-end">{{ $rentoutRoomValue->room->room_no }}</td>
                                                <td class="text-end">{{ $rentoutRoomValue->roomDates->count() }}</td>
                                                <td class="text-end">{{ currency($rentoutRoomValue->roomDates->sum('amount')) }}</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table border-top  table-sm table-bordered table-striped table-hover">
                <tfoot>
                    <tr>
                        <td class="align-top px-4 py-3">
                            <table class="table border-top table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Payment Mode</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Self->payments as $key => $value): ?>
                                        <tr>
                                            <td>{{ $value->payment_mode }}</td>
                                            <td class="text-end">{{ currency($value->amount) }}</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                        <td class="align-top px-4 py-3">
                            <table class="table border-top table-striped table-hover table-sm">
                                    <tr>
                                        <th>Subtotal</th>
                                        <td class="text-end">{{ currency($Self->total) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td class="text-end">{{ currency($Self->tax) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount Amount</th>
                                        <td class="text-end">{{ currency($Self->special_discount_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Additional Charges</th>
                                        <td class="text-end">{{ currency($Self->additional_charges) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-end">{{ currency($Self->grand_total) }}</td>
                                    </tr>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-semibold">TERMS & CONDITIONS:</span>
                <ol>
                    <li> Terms of Use Our Site may use "cookies"to enhance User experience!</li>
                    <li> User's web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them</li>
                    <li> User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent</li>
                    <li> If they do so, note that some parts of the Site may not function properly</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-6">Guest Signature</div>
            <div class="col-6 text-end">Authorized Signature</div>
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
