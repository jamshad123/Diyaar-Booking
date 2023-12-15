<?php use App\Models\Room; ?>
<div>
    <div class="row">
        <?php foreach ($datas as $key => $value) : ?>
            <div class="col-md-3 col-lg-2 mb-4">
                <div class="card h-100">
                    <div class="card-header flex-grow-0">
                        <div class="d-flex">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                                <div class="me-2">
                                    <h5 class="mb-0">Floor No : {{ $value['floor'] }}</h5>
                                    <small class="text-muted">{{ systemDate($date) }}</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center nowrap">
                                <?php
                                $button_class = '';
                                $image_link = asset('assets/img/backgrounds/7.jpg');
                                switch ($value['booking_status']) {
                                    case Room::Pending:
                                    $button_class = 'btn-success';
                                    $image_link = asset('assets/img/booked.jpeg');
                                    break;
                                    case Room::Booked:
                                    $button_class = 'btn-info';
                                    $image_link = asset('assets/img/booked.jpeg');
                                    break;
                                    case Room::CheckIn:
                                    $button_class = 'btn-warning';
                                    $image_link = asset('assets/img/booked.jpeg');
                                    break;
                                    case Room::Vacant:
                                    $button_class = 'btn-primary';
                                    if($value['hygiene_status']==Room::Clean){
                                        $image_link = asset('assets/img/clean.jpeg');
                                    } else {
                                        $image_link = asset('assets/img/cleaning.jpeg');
                                    }
                                    break;
                                    case Room::Maintenance:
                                    $button_class = 'btn-secondary';
                                    $image_link = asset('assets/img/backgrounds/7.jpg');
                                    break;
                                }
                                if($value['status']==Room::Maintenance){
                                    $image_link = asset('assets/img/maintenance.avif');
                                }
                                if($value['status']==Room::InActive){
                                    $image_link = asset('assets/img/inactive_2.jpeg');
                                }
                                ?>
                                <a href="javascript:;" wire:click="ViewModal({{$value['id']}})" style="width:100%" class="btn {{ $button_class }} btn-sm" role="button">{{ $value['booking_status'] }}</a>
                            </div>
                        </div>
                    </div>
                    <img class="img-fluid" style="height: 100%;" src="{{ $image_link }}" alt="Card image cap">
                    <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-150 shadow text-center p-1">
                        <span class="text-primary">Room No</span>
                        <h5 class="mb-0 text-dark">{{ $value['room_no'] }}</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="text-truncate">Room Type : {{ $value['type'] }}</h5>
                        <div class="d-flex gap-2">
                            <?php
                            switch ($value['hygiene_status']) {
                                case Room::Clean:
                                $className = 'bg-label-primary';
                                break;
                                case Room::Dirty:
                                $className = 'bg-label-danger';
                                break;
                            }
                            ?>
                            <span class="badge {{ $className }}">{{ $value['hygiene_status'] }}</span>
                            <?php
                            switch ($value['status']) {
                                case Room::Active:
                                $className = 'bg-label-primary';
                                break;
                                case Room::Maintenance:
                                $className = 'bg-label-danger';
                                break;
                            }
                            ?>
                            <span class="badge {{ $className }}">{{ $value['status'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    @section('script')
    @parent
    <script type="text/javascript">
    $(document).ready(function() {
        $('#booking_status').on('change', function(e) {
            @this.set('booking_status', $(this).val());
        });
        $('#date').on('change', function(e) {
            @this.set('date', $(this).val());
        });
        $('#floor').on('change', function(e) {
            @this.set('floor', $(this).val());
        });
        $('#hygiene_status').on('change', function(e) {
            @this.set('hygiene_status', $(this).val());
        });
        $('#status').on('change', function(e) {
            @this.set('status', $(this).val());
        });
        $('#type').on('change', function(e) {
            @this.set('type', $(this).val());
        });
    });
    </script>
    @stop
</div>
