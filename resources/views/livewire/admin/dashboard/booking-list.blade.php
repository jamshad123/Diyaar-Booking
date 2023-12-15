<div>
    <div class="table-responsive text-start">
        <table class="table text-nowrap table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Rentout as $key => $value): ?>
                <tr>
                    <td><a href="{{ route('Rentout::edit',$value->id) }}">{{ $value->id }}</a> </td>
                    <td><a href="{{ route('Rentout::edit',$value->id) }}">{{ $value->customer->full_name }}</a></td>
                    <td><a href="{{ route('Rentout::edit',$value->id) }}">{{ $value->customer->mobile }}</a></td>
                    <td>{{ systemDate($value->check_in_date) }}</td>
                    <td>{{ systemDate($value->check_out_date) }}</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>