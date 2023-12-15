<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="AgentCreateTitle">Day Closing ( {{ systemDateTime($daily_collections['opening_time']) }} -
                {{ date('d/m/Y h:i A') }} )
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
                <div class="col">
                    <div class="table-responsive text-start">
                        <table class="table table-bordered   dataTable">
                            <thead>
                                <tr>
                                    <th>Payment Type</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentsData as $payment_mode => $amount)
                                <tr>
                                    <td>{{ $payment_mode }} </td>
                                    <td class="text-end">{{ currency($amount) }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-end" rowspan="1">Total:</td>
                                    <td class="text-end">{{ currency(array_sum($paymentsData)) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end" rowspan="1">Opening Balance</td>
                                    <td class="text-end">{{ currency($DailyCollection['opening_balance']??0) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col">
                            <label class="col-sm-4 col-form-label">Closing Balance</label>
                            {{ Form::number('closing_balance','',['wire:model'=>'daily_collections.closing_balance','class'=>'form-control','placeholder'=>'Closing Balance']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label class="col-sm-4 col-form-label"></label>
                            {{Form::textarea('closing_note','',['wire:model'=>'daily_collections.closing_note','class'=>'form-control','placeholder'=>'Closing Note']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Set closing balance</button>
        </div>
    </form>
    @section('script')
    @parent
    @stop
</div>