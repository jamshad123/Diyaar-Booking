<div>
    <div class="card">
        <div class="card-datatable table-responsive" wire:ignore>
            {!! $htmlBuilder->table(['class'=>"table border-top  "],true) !!}
        </div>
    </div>
    @section('script')
    @parent
    {!! $htmlBuilder->scripts() !!}
    <script type="text/javascript">
        $(document).ready(function () {
            dataTable = window.LaravelDataTables.dataTableBuilder;
            window.addEventListener('TableDraw', event => {
                dataTable.draw();
            });
            $('.table_change').change(function () {
                dataTable.draw();
            });
            $(document).on('click', '.edit', function () {
                window.livewire.emit("EditRole", $(this).attr('table_id'));
            });
            $(document).on('click', '.permissions', function () {
                window.livewire.emit("EditPermission", $(this).attr('table_id'));
            });
        });
    </script>
    @stop
</div>