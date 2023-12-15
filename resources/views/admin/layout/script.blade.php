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
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@include('components.buildingSelect2')
@yield('vendor-script')
<script type="text/javascript">
    $('.select2_class').select2();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('shown.bs.modal', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
        $.fn.modal.Constructor.prototype.enforceFocus = function () { };
        toastr.options = {
            maxOpened: 10,
            autoDismiss: true,
            closeButton: true,
            debug: true,
            newestOnTop: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null,
        };
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.title,
                text: event.detail.text,
            });
        });
        window.addEventListener('success', event => {
            if (typeof (event.detail.title) != "undefined" && typeof (event.detail.message) != "undefined") {
                toastr.info(event.detail.message, event.detail.title);
                return false;
            }
            if (typeof (event.detail.title) != "undefined") {
                toastr.info(event.detail.title);
                return false;
            }
            if (typeof (event.detail.message) != "undefined") {
                toastr.info(event.detail.message);
                return false;
            }
        });
        window.addEventListener('warning', event => {
            if (typeof (event.detail.title) != "undefined" && typeof (event.detail.message) != "undefined") {
                toastr.warning(event.detail.message, event.detail.title);
                return false;
            }
            if (typeof (event.detail.title) != "undefined") {
                toastr.warning(event.detail.title);
                return false;
            }
            if (typeof (event.detail.message) != "undefined") {
                toastr.warning(event.detail.message);
                return false;
            }
        });
        window.addEventListener('error', event => {
            if (event.detail) {
                toastr.error(event.detail.message)
            }
            if (event.error) {
                toastr.error(event.error.message)
            }
        });
    });
</script>