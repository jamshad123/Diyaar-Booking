<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="BuildingCreateTitle">Coupon Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @error('coupons.amount') <span style="color:red" class="error"> * {{ $message }} <br> </span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('amount','Amount *',['class'=>'form-label']) }}
                    {{ Form::text('amount','',['wire:model'=>'coupons.amount','class'=>'form-control','placeholder'=>'Please Enter amount']) }}
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    {{ Form::label('expiry_at','Expiry At *',['class'=>'form-label']) }}
                    {{ Form::date('expiry_at','',['wire:model'=>'coupons.expiry_at','class'=>'form-control','placeholder'=>'Please Enter amount']) }}
                </div>
                <div class="col mb-3">
                    {{ Form::label('no_of_coupon','no of coupon *',['class'=>'form-label']) }}
                    {{ Form::number('no_of_coupon','',['wire:model'=>'coupons.no_of_coupon','class'=>'form-control','placeholder'=>'Please Enter No Of Coupon']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>