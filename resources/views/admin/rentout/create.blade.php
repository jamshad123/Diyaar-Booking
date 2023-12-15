@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    @livewire('admin.rentout.register.create',['rentout_id'=>$id])
</div>
@component('components.CustomerModal') @endcomponent
@component('components.AgentModal') @endcomponent
@component('components.SelectRoomModal') @endcomponent
@component('components.AddExistingCustomerModal') @endcomponent
@endsection
@section('style')
@endsection
@section('vendor-style')
@include('components.datatableCssFiles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@include('components.datatableJsFiles')
@include('components.agentSelect2')
@include('components.customerSelect2')
<script type="text/javascript">
    SelectedTableDataTable = $('#SelectedTableDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "fixedHeader": true,
        'bInfo': false,
        'paging': false,
        'scrollY': "40vh",
        'scrollCollapse': true,
        "ajax": {
            "url": "<?= route('Rentout::selectedRoom::datatable') ?>",
            "dataType": "json",
            "type": "POST",
            data: function (d) {
                d._token = "{{ csrf_token() }}";
                d.floor = $("#select_modal_floor").val();
                d.type = $("#select_modal_type").val();
                d.selectedRooms = $("#selectedRooms").val();
            },
        },
        dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 justify-content-center justify-content-md-end"Bf>>t<"row"<"col-sm-12 col-md-2"i><"col-sm-12 col-md-10"p>>',
        'language': {
            'sLengthMenu': '_MENU_',
            'search': '',
            'searchPlaceholder': 'Search..',
        },
        'buttons': [{
            'text': '<i class ="bx bx-trash me-0 me-sm-2"></i><span class ="d-none d-lg-inline-block">Delete</span>',
            'className': 'add-new btn btn-secondary',
            'action': function (e, dt, node, config) {
                selectedRows = SelectedTableDataTable.rows(".selected").data();
                selectedId = [];
                selectedRows.each((item, i) => {
                    selectedId.push(item.id);
                });
                if (!selectedId.length) {
                    Swal.fire("Error!", "Please Select Any Room To Add it", "error");
                    return false
                }
                if (!confirm("Are You Sure To Add Selected(" + selectedId.length + ") Room(s)!")) {
                    return false;
                }
                window.livewire.emit("RemoveRooms", selectedId);
            },
        },],
        "columns": [
            { "data": "id", "checkboxes": { "selectRow": true, "selectAllRender": "<input type='checkbox' class='form-check-input'>" } },
            { "data": "room_no", 'className': 'text-end' },
            { "data": "type", },
            { "data": "floor", 'className': 'text-end' },
            { "data": "no_of_beds", 'className': 'text-end' },
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
    });
</script>
@endsection