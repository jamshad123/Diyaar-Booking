<div class="modal fade" id="AgentModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        @livewire('admin.agent.create')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
$('#agent_id').on("select2:select change", function(e) {
    if($(this).val()=='Add') {
        $('#agent_id').val(null).change();
        window.livewire.emit("CreateAgent");
        $("#AgentModal").modal("show");
    }
});
$('#modal_agent_id').on("select2:select change", function(e) {
    if($(this).val()=='Add') {
        $('#modal_agent_id').val(null).change();
        window.livewire.emit("CreateAgent");
        $("#AgentModal").modal("show");
    }
});
window.addEventListener('AppendAgentLastData', event => {
    $('#modal_agent_id').append($("<option></option>").attr("value",event.detail.id).text(event.detail.text));
    $('#modal_agent_id').val(event.detail.id).trigger('change');
    $('#agent_id').append($("<option></option>").attr("value",event.detail.id).text(event.detail.text));
    $('#agent_id').val(event.detail.id).trigger('change');
});
</script>
@stop
