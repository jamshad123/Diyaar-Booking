<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="OfferCreateTitle">Offer Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @if($this->getErrorBag()->count())
                    <ol>
                        <?php foreach ($this->getErrorBag()->toArray() as $key => $value): ?>
                        <li style="color:red">* {{ $value[0] }}</li>
                        <?php endforeach; ?>
                    </ol>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('start_date','Start Date *',['class'=>'form-label']) }}
                    {{ Form::date('start_date','',['wire:model'=>'offers.start_date','class'=>'form-control']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('end_date','End Date *',['class'=>'form-label']) }}
                    {{ Form::date('end_date','',['wire:model'=>'offers.end_date','class'=>'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('amount','Amount *',['class'=>'form-label']) }}
                    {{ Form::text('amount','',['wire:model'=>'offers.amount','class'=>'form-control','placeholder'=>'Please Enter amount']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
