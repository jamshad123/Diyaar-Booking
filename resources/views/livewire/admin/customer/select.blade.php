<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header ">
            <h5 class="modal-title">Existing Customer List</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card" style="background-color: #d9dee3;">
                <div class="row" style="padding: 10px 10px;">
                    <div class="col mb-2">
                        {{ Form::label('search_tag', 'Search Tag *', ['class' => 'form-label']) }}
                        {{ Form::text('search_tag', '', ['wire:model' => 'search_tag', 'class' => 'form-control', 'placeholder' => 'Please Enter any keyword', 'style' => 'border-radius: 8px;']) }}
                    </div>
                    <div class="col mb-2">
                        {{ Form::label('search_customer_id', 'Search by Cust.ID', ['class' => 'form-label']) }}
                        {{ Form::text('search_customer_id', '', ['wire:model' => 'search_customer_id', 'class' => 'form-control', 'placeholder' => 'Enter Customer ID', 'style' => 'border-radius: 8px;']) }}
                    </div>
                    <div class="col mb-2">
                        {{ Form::label('search_customer_id', 'Search by Cust.Name', ['class' => 'form-label']) }}
                        {{ Form::text('search_customer_id', '', ['wire:model' => 'search_customer_id', 'class' => 'form-control', 'placeholder' => 'Enter Customer Name', 'style' => 'border-radius: 8px;']) }}
                    </div>
                    <div class="col mb-2">
                        {{ Form::label('search_dob', 'Search by DOB', ['class' => 'form-label']) }}
                        {{ Form::date('search_dob', '', ['wire:model' => 'search_dob', 'class' => 'form-control', 'style' => 'border-radius: 8px;']) }}
                    </div>
                    <div class="col mb-2">
                        {{ Form::label('search_phone_number', 'Search by Ph. No', ['class' => 'form-label']) }}
                        {{ Form::text('search_phone_number', '', ['wire:model' => 'search_phone_number', 'class' => 'form-control', 'placeholder' => 'Enter Phone Number', 'style' => 'border-radius: 8px;']) }}
                    </div>
                    <div class="col mb-2">
                        {{ Form::label('search_company', 'Search by Company', ['class' => 'form-label']) }}
                        {{ Form::select('search_company', $companies, null, ['wire:model' => 'search_company', 'class' => 'form-control', 'placeholder' => 'Select Company', 'style' => 'border-radius: 8px;']) }}
                    </div>
                </div>
            </div>



            <div class="row" style="margin-top: 10px; overflow-y: auto;">
                <table class="table table-sm table-bordered table-hover table-sm table-striped">
                    <thead style="background-color: #d9dee3;">
                        <tr>
                            <th>Name </th>
                            <th>Mobile</th>
                            <th>Company</th>
                            <th>Country</th>
                            <th>Date of Birth</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $value)
                            <tr>
                                <td>{{ $value->full_name }}</td>
                                <td>{{ $value->mobile }}</td>
                                <td>{{ $value->company }}</td>
                                <td>{{ $value->country }}</td>
                                <td>{{ $value->dob }}</td>
                                <td>{{ $value->phone_number }}</td>
                                <td class="text-class" style="padding-left: 30px;"><i wire:click="addCustomer('{{ $value->id }}')" class="fa fa-2x fa-plus pointer_class"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
        </div>
    </form>
</div>
