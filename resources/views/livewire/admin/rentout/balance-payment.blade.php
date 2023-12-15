<div>
    <form wire:submit.prevent="save">
        <div class="row mb-2">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="fs-17 font-weight-600 mb-0">Bill Settlement</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="45%">Payment Mode</th>
                                    <th width="40%">Amount</th>
                                    <th width="5%">Action</th>
                                </tr>
                                <tr>
                                    <td width="45%" wire:ignore>{{ Form::select('payment_mode',paymentModeOptions(),'Direct Payment',['wire:model'=>'payment.payment_mode','class'=>'form-control select2_class','placeholder'=>'Select Any Mode','id'=>'payment_mode']) }}</td>
                                    <td width="40%"><input style="width:100%" type="number" class="form-control" wire:model="payment.amount" min="0"> </td>
                                    <td width="5%"> <button type="button" wire:click="AddPayment" class="btn btn-sm btn-primary" name="button"><i class="fa fa-plus"></i></button> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments??[] as $key => $value): ?>
                                <tr>
                                    <td>{{ $value['payment_mode'] }}</td>
                                    <td class="text-end">
                                        @if(isset($value['id']))
                                        @endif
                                        <span>{{ currency($value['amount']) }}</span>
                                    </td>
                                    <td width="5%">
                                        <button type="button" wire:click="RemovePayment('{{ $key }}')" class="btn btn-sm btn-danger" name="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header sticky-element  d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0">
                    </h5>
                    <div class="action-btns">
                        <button type="submit" class="btn btn-primary"> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </form>@section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('#payment_mode').on('select2:select change', function (e) {
                @this.set('payment.payment_mode', $(this).val());
            });
        });
    </script>
    @stop
</div>
