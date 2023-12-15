<div>
    <div class="card">
        <div class="card-header">
            <div class="row" wire:ignore>
                <div class="mb-3 col-md-3">
                    {{ Form::label('date','Date *',['class'=>'form-label']) }}
                    {{ Form::date('date','',['wire:model.defer'=>'date','class'=>'form-control table_change','id'=>'date']) }}
                </div>
                <div class="mb-3 col-md-1"> <br>
                    <button type="button" id="fetchButton" class="btn btn-primary" name="button">Fetch</button>
                </div>
                <div class="mb-3 col-md-1"> <br>
                    <button type="button" id="printButton" class="btn btn-info" name="button">Print</button>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <p>
                <span class='badge bg-label-info'>Check In</span>
                <span class='badge bg-label-primary'>Booked</span>
                <span class='badge bg-label-secondary'>Checkout</span>
            </p>
            <div class="card-datatable table-responsive" wire:ignore>
                {!! $htmlBuilder->table(['class'=>"dt-fixedheader dt-scrollableTable dt-fixedcolumns table border-top table-bordered dataTable no-footer",'id'=>'RoomStatusDataTable'],true) !!}
            </div>
        </div>
    </div>
    @section('script')
    @parent
    {!! $htmlBuilder->scripts() !!}
    <script type="text/javascript">
        $(document).ready(function () {
            RoomStatusDataTable = window.LaravelDataTables['RoomStatusDataTable'];
            $('#fetchButton').click(function () {
                RoomStatusDataTable.draw();
            });
            $('#printButton').click(function () {
                window.livewire.emit("Print");
            });
            if (window.Helpers.isNavbarFixed()) {
                var navHeight = $('#layout-navbar').outerHeight() + 12;
                new $.fn.dataTable.FixedHeader(RoomStatusDataTable).headerOffset(navHeight);
            } else {
                new $.fn.dataTable.FixedHeader(RoomStatusDataTable);
            }
        });
    </script>
    @stop
</div>