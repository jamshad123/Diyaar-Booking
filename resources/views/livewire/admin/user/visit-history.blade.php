<div>
    <div class="table-responsive">
        <table class="table border-top">
            <thead>
                <tr>
                    <th class="text-truncate">Browser</th>
                    <th class="text-truncate">Ip Address</th>
                    <th class="text-truncate">Device</th>
                    <th class="text-truncate">Recent Activities</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $value)
                <tr>
                    <td class="text-truncate">
                        <i class="bx bxl-windows text-info me-3"></i>
                        <span class="fw-semibold">{{ $value['browser'] }}</span>
                    </td>
                    <td class="text-truncate">{{ $value['ip'] }}</td>
                    <td class="text-truncate">{{ $value['device'] }}({{ $value['platform'] }})</td>
                    <td class="text-truncate">{{ systemDateTime($value['created_at']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col"> </div>
            <div class="col"> <br>
                {!! $lists->links() !!}
            </div>
            <div class="col"> </div>
        </div>
    </div>
</div>