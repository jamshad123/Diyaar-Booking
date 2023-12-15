<div class="card">
    <form wire:submit.prevent="save">
        <div class="card-header">
            <h3> General Settings </h3>
        </div>
        <div class="card-header">
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">tax percentage</label>
                        {!! Form::number('tax_percentage','',['wire:model.defer'=>'settings.tax_percentage','step'=>'any','class'=>"form-control"]); !!}
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">minimum room rent</label>
                        {!! Form::number('minimum_room_rent_building_id_','',['wire:model.defer'=>'settings.minimum_room_rent_building_id_'.session('building_id'),'class'=>"form-control"]); !!}
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">extra bed charge</label>
                        {!! Form::number('extra_bed_charge','',['wire:model.defer'=>'settings.extra_bed_charge','class'=>"form-control"]); !!}
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">VAT Registration No</label>
                        {!! Form::number('vat_registration_no_building_id_','',['wire:model.defer'=>'settings.vat_registration_no_building_id_'.session('building_id'),'class'=>"form-control"]); !!}
                        </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary"> Save </button>
                </div>
            </div>
        </div>
    </form>
</div>