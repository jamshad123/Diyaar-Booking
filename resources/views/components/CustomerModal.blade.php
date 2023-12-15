<div class="modal fade" id="CustomerModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        @livewire('admin.customer.create')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
$('#modal_customer_id').on("select2:select change", function(e) {
    if($(this).val()=='Add') {
        $('#modal_customer_id').val(null).change();
        window.livewire.emit("CreateCustomer");
        $("#CustomerModal").modal("show");
    }
});
window.addEventListener('AppendCustomerLastData', event => {
    $('#modal_customer_id').append($("<option></option>").attr("value",event.detail.id).text(event.detail.text));
    $('#modal_customer_id').val(event.detail.id).trigger('change');
    $('#customer_id').append($("<option></option>").attr("value",event.detail.id).text(event.detail.text));
    $('#customer_id').val(event.detail.id).trigger('change');
});
</script>
@stop
