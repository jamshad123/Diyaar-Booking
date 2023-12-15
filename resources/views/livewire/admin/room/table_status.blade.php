<?php use App\Models\Room; ?>
<div>
    <div class="card">
        <div class="card-body">
            <div class=" table-responsive">
                <table class="table card-table" id="dataTabless">
                    <thead>
                        <th class="text-end nowrap">No</th>
                        <th class="nowrap">Floor</th>
                        <th class="nowrap">Type</th>
                        <th class="nowrap">Hygiene Status</th>
                        <th class="nowrap">Room Status</th>
                        <?php foreach ($tableDates as $date): ?>
                            <th class="nowrap">{{ systemDate($date) }}</th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php foreach ($tableContent as $key => $value): ?>
                            <tr>
                                <td class="text-end">{{ $value['room_no'] }}</td>
                                <td>{{ $value['floor'] }}</td>
                                <td>{{ $value['type'] }}</td>
                                <td width="10%">
                                    @switch($value['hygiene_status'])
                                    @case('Clean')
                                    <span class="badge bg-label-success">{{ $value['hygiene_status'] }}</span>
                                    @break
                                    @case('Dirty')
                                    <span class="badge bg-label-warning">{{ $value['hygiene_status'] }}</span>
                                    @break
                                    @endswitch
                                </td>
                                <td width="10%">
                                    @switch($value['status'])
                                    @case('Active')
                                    <span class="badge bg-label-success">{{ $value['status'] }}</span>
                                    @break
                                    @case('Maintenance')
                                    <span class="badge bg-label-warning">{{ $value['status'] }}</span>
                                    @break
                                    @endswitch
                                </td>
                                <?php foreach ($value['dates'] as $td): ?>
                                    {!! $td !!}
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        $('#booking_status').on('change', function(e) {
            @this.set('booking_status', $(this).val());
        });
        $('#from_date').on('change', function(e) {
            @this.set('from_date', $(this).val());
        });
        $('#to_date').on('change', function(e) {
            @this.set('to_date', $(this).val());
        });
        $('#floor').on('change', function(e) {
            @this.set('floor', $(this).val());
        });
        $('#hygiene_status').on('change', function(e) {
            @this.set('hygiene_status', $(this).val());
        });
        $('#status').on('change', function(e) {
            @this.set('status', $(this).val());
        });
        $('#type').on('change', function(e) {
            @this.set('type', $(this).val());
        });
        $('#FetchButton').on('click', function(e) {
            window.livewire.emit("Fetch");
        });
    });
</script>
@stop
</div>
