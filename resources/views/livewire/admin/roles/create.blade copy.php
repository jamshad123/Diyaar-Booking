<div>
    <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center">
            <h3 class="role-title">Role And Permission</h3>
            <p>Set Role Permissions</p>
        </div>
        <form wire:submit.prevent="save" class="row fv-plugins-bootstrap5 fv-plugins-framework">
            @if($this->getErrorBag()->count())
            <div class="col-12 v-plugins-icon-container">
                <ol>
                    <?php foreach ($this->getErrorBag()->toArray() as $key => $value) { ?>
                    <li style="color: red">* {{ $value[0] }}</li>
                    <?php } ?>
                </ol>
            </div>
            @endif
            <div class="col-12 fv-plugins-icon-container">
                {{ Form::label('name','Role Name *',['class'=>'form-label']) }}
                {{ Form::text('name','',['wire:model'=>'roles.name','class'=>'form-control','placeholder'=>'Please Enter Role Name','required']) }}
                <div class="fv-plugins-message-container invalid-feedback"></div>
            </div>
            <div class="col-12 mb-2 fv-plugins-icon-container">
                {{ Form::label('description','Description',['class'=>'form-label']) }}
                {{ Form::text('description','',['wire:model'=>'roles.description','class'=>'form-control','placeholder'=>'Please Enter Role Description']) }}
                <div class="fv-plugins-message-container invalid-feedback"></div>
            </div>
            <div class="col-12">
                <h4>Role Permissions</h4>
                <div class="table-responsive">
                    <table class="table table-flush-spacing">
                        <thead>
                            <tr>
                                <td class="text-nowrap fw-semibold"> Permission </td>
                                <td class="text-nowrap fw-semibold"> Check </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="1" class="text-nowrap fw-semibold">
                                    Administrator Access
                                    <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Allows a full access to the system"></i>
                                </td>
                                <td colspan="4">
                                    <div class="form-check" wire:ignore>
                                        <input class="form-check-input" wire:model.defer="selectAll" type="checkbox" id="selectAll" />
                                        <h5><label class="form-check-label" for="selectAll"> <b>Select All</b> </label></h5>
                                    </div>
                                </td>
                            </tr>
                            @foreach($modules as $module => $sub_modules)
                            <tr>
                                <td colspan="2" class="text-nowrap fw-semibold">
                                    <h3>{{ $module }}</h3>
                                </td>
                            </tr>
                            @foreach($sub_modules as $sub_module => $value1)
                            @if($permission[$sub_module] && is_array($permission[$sub_module]))
                            <tr>
                                <td colspan="2">
                                    <table class="table">
                                        <tr>
                                            <th width="20%">{{ $sub_module }}</th>
                                            @foreach($permission[$sub_module] as $key=> $value2)
                                            <th>
                                                {{ $value2 }}
                                                <div class="form-check me-3 me-lg-5">
                                                    <input wire:model="permission.{{$key}}" value="true" type="checkbox" id="{{ $key }}" class="form-check-input permissions" />
                                                </div>
                                            </th>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>{{ $sub_module }} </td>
                                <th>
                                    <div class="form-check me-3 me-lg-5">
                                        <input wire:model="permission.{{$key}}" value="true" type="checkbox" id="{{ $key }}" class="form-check-input permissions" />
                                    </div>
                                </th>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-center">
                <label class="switch switch-lg">
                    <input type="checkbox" wire:model="closeFlag" class="switch-input" checked />
                    <span class="switch-toggle-slider">
                        <span class="switch-on"> <i class="bx bx-check"></i> </span>
                        <span class="switch-off"> <i class="bx bx-x"></i> </span>
                    </span>
                    <span class="switch-label">Close window on save</span>
                </label>
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
            <input type="hidden" />
        </form>
    </div>
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
            $('#modal_customer_type').on('change', function (e) {
                @this.set('customers.customer_type', $(this).val());
            });
            const selectAll = document.querySelector('#selectAll');
            checkboxList = document.querySelectorAll('.permissions[type="checkbox"]');
            selectAll.addEventListener('change', t => {
                checkboxList.forEach(e => {
                    @this.set('permission.' + e.id, t.target.checked);
                });
            });
        });
    </script>
    @stop
</div>