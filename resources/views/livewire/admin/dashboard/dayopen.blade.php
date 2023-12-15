<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="AgentCreateTitle">Day Opening ({{ systemDateTime($daily_collections['opening_time']) }} - )
            </h5>
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
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col">
                            <label class="col-sm-4 col-form-label">Opening Balance</label>
                            {{ Form::number('opening_balance','',['wire:model'=>'daily_collections.opening_balance','class'=>'form-control','placeholder'=>'Opening Balance']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label class="col-sm-4 col-form-label"></label>
                            {{Form::textarea('opening_note','',['wire:model'=>'daily_collections.opening_note','class'=>'form-control','placeholder'=>'Opening Note']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Set Opening balance</button>
        </div>
    </form>
    @section('script')
    @parent
    @stop
</div>