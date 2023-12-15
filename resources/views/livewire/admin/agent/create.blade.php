<?php use App\Models\Customer; ?>
<div>
    <form wire:submit.prevent="save" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="CustomerCreateTitle">Agent Modal</h5>
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
            <div class="row mb-2">
                <div class="col">
                    {{ Form::label('first_name','First Name *',['class'=>'form-label']) }}
                    {{ Form::text('first_name','',['wire:model'=>'agents.first_name','class'=>'form-control form-control-sm','placeholder'=>'Please Enter First Name','required']) }}
                </div>
                <div class="col">
                    {{ Form::label('second_name','Second Name',['class'=>'form-label']) }}
                    {{ Form::text('second_name','',['wire:model'=>'agents.second_name','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Second Name']) }}
                </div>
                <div class="col">
                    {{ Form::label('middle_name','Middle Name',['class'=>'form-label']) }}
                    {{ Form::text('middle_name','',['wire:model'=>'agents.middle_name','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Middle Name']) }}
                </div>
                <div class="col">
                    {{ Form::label('last_name','Last Name',['class'=>'form-label']) }}
                    {{ Form::text('last_name','',['wire:model'=>'agents.last_name','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Last Name']) }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-2">
                        <div class="col">
                            {{ Form::label('father_name','Father Name',['class'=>'form-label']) }}
                            {{ Form::text('father_name','',['wire:model'=>'agents.father_name','class'=>'form-control form-control-sm','placeholder'=>'Please Enter First Name']) }}
                        </div>
                        <div class="col">
                            {{ Form::label('occupation','Occupation',['class'=>'form-label']) }}
                            {{ Form::text('occupation','',['wire:model'=>'agents.occupation','class'=>'form-control form-control-sm','placeholder'=>'Please Enter occupation']) }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            {{ Form::label('mobile','Mobile *',['class'=>'form-label']) }}
                            {{ Form::text('mobile','',['wire:model'=>'agents.mobile','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Mobile','required']) }}
                        </div>
                        <div class="col">
                            {{ Form::label('email','Email',['class'=>'form-label']) }}
                            {{ Form::text('email','',['wire:model'=>'agents.email','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Email']) }}
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col">
                            {{ Form::label('date_of_birth','Date of Birth',['class'=>'form-label']) }}
                            {{ Form::date('date_of_birth','',['wire:model'=>'agents.date_of_birth','class'=>'form-control form-control-sm','placeholder'=>'Please select Date of Birth']) }}
                        </div>
                        <div class="col">
                            {{ Form::label('gender','Gender *',['class'=>'form-label']) }}
                            {{ Form::select('gender',genderOptions(),'',['wire:model'=>'agents.gender','class'=>'form-control form-control-sm','placeholder'=>'Please select Date of Birth','required']) }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-2">
                        <div class="col">
                            {{ Form::label('country','Country',['class'=>'form-label']) }}
                            {{ Form::select('country',[''=>'Select Any']+$Countries,'',['wire:model'=>'agents.country','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Country',$country_disable]) }}
                        </div>
                        <div class="col">
                            {{ Form::label('state','State',['class'=>'form-label']) }}
                            {{ Form::text('state','',['wire:model'=>'agents.state','class'=>'form-control form-control-sm','placeholder'=>'Please Enter state']) }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            {{ Form::label('city','City',['class'=>'form-label']) }}
                            {{ Form::text('city','',['wire:model'=>'agents.city','class'=>'form-control form-control-sm','placeholder'=>'Please Enter city']) }}
                        </div>
                        <div class="col">
                            {{ Form::label('zip_code','Zip Code',['class'=>'form-label']) }}
                            {{ Form::text('zip_code','',['wire:model'=>'agents.zip_code','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Zip Code']) }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col" wire:ignore>
                            {{ Form::label('customer_type','Type *',['class'=>'form-label']) }}
                            {{ Form::select('customer_type',customerTypeOptions(),'',['wire:model'=>'agents.customer_type','class'=>'form-control form-control-sm','placeholder'=>'Please Select Customer Type','required','id'=>'modal_agent_type']) }}
                        </div>
                        <div class="col">
                            {{ Form::label('document_type','Document Type *',['class'=>'form-label']) }}
                            {{ Form::select('document_type',documentTypeOptions(),'',['wire:model'=>'agents.document_type','class'=>'form-control form-control-sm','placeholder'=>'Please select Document Type','required']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    {{ Form::label('issue_place','Issue Place',['class'=>'form-label']) }}
                    {{ Form::text('issue_place','',['wire:model'=>'agents.issue_place','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Issue Place']) }}
                </div>
                <div class="col">
                    {{ Form::label('expiry_date','Expiry Date',['class'=>'form-label']) }}
                    {{ Form::date('expiry_date','',['wire:model'=>'agents.expiry_date','class'=>'form-control form-control-sm','placeholder'=>'Please Select Expiry Date']) }}
                </div>
                @switch($agents['document_type'])
                @case(Customer::IDCard)
                <div class="col">
                    {{ Form::label('id_no','ID No *',['class'=>'form-label']) }}
                    {{ Form::text('id_no','',['wire:model'=>'agents.id_no','class'=>'form-control form-control-sm','placeholder'=>'Please Enter ID No']) }}
                </div>
                @break
                @case(Customer::Passport)
                <div class="col">
                    {{ Form::label('passport_no','Passport No *',['class'=>'form-label']) }}
                    {{ Form::text('passport_no','',['wire:model'=>'agents.passport_no','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Passport No']) }}
                </div>
                <div class="col">
                    {{ Form::label('visa_no','Visa No *',['class'=>'form-label']) }}
                    {{ Form::text('visa_no','',['wire:model'=>'agents.visa_no','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Visa No']) }}
                </div>
                @break
                @case(Customer::ResidencePermit)
                <div class="col">
                    {{ Form::label('iqama_no','IQAMA No *',['class'=>'form-label']) }}
                    {{ Form::text('iqama_no','',['wire:model'=>'agents.iqama_no','class'=>'form-control form-control-sm','placeholder'=>'Please Enter IQAMA No']) }}
                </div>
                @break
                @case(Customer::GCCID)
                <div class="col">
                    {{ Form::label('qccid_no','Q.C.C ID No *',['class'=>'form-label']) }}
                    {{ Form::text('qccid_no','',['wire:model'=>'agents.qccid_no','class'=>'form-control form-control-sm','placeholder'=>'Please Enter Q.C.C ID No']) }}
                </div>
                @break
                @endswitch
            </div>
            <div class="row mb-2">
                <div class="col">
                    {{ Form::label('address','Address *',['class'=>'form-label']) }}
                    {{ Form::textarea('address','',['wire:model'=>'agents.address','rows'=>4,'class'=>'form-control form-control-sm','placeholder'=>'Please Enter Address']) }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{ Form::label('comments','comments *',['class'=>'form-label']) }}
                    {{ Form::textarea('comments','',['wire:model'=>'agents.comments','rows'=>4,'class'=>'form-control form-control-sm','placeholder'=>'Please Enter your Comments']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <label class="switch switch-lg">
                <input type="checkbox" wire:model="closeFlag" class="switch-input" checked />
                <span class="switch-toggle-slider">
                    <span class="switch-on"> <i class="bx bx-check"></i> </span>
                    <span class="switch-off"> <i class="bx bx-x"></i> </span>
                </span>
                <span class="switch-label">Close window on save</span>
            </label>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    @section('style')
    @parent
    <style media="screen">
        .form-label {
            font-size: 13px;
        }
    </style>
    @stop
    @section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            window.addEventListener('CloseAgentModal', event => {
                $("#AgentModal").modal("hide");
            });
            window.addEventListener('OpenAgentModal', event => {
                $("#AgentModal").modal("show");
            });
            $('#modal_agent_type').on('change', function (e) {
                @this.set('agents.customer_type', $(this).val());
            });
        });
    </script>
    @stop
</div>