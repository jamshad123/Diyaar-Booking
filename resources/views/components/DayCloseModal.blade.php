<div class="modal fade" id="DayOpenModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        @livewire('admin.dashboard.dayopen')
    </div>
</div>
<div class="modal fade" id="DayCloseModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        @livewire('admin.dashboard.dayclose')
    </div>
</div>
@section('script')
@parent
<script type="text/javascript">
    $(document).ready(function () {
        window.addEventListener('CallDayOpenModel', event => {
            $("#DayOpenModal").modal("show");
        });
        window.addEventListener('CloseDayOpenModel', event => {
            $("#DayOpenModal").modal("hide");
        });
        window.addEventListener('CloseDayCloseModal', event => {
            $("#DayCloseModal").modal("hide");
        });
    });
</script>
@stop