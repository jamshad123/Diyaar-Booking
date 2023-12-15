<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Building Settings /</span> {{ $buildings['name'] }}</h4>
    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills flex-column flex-md-row mb-3" role="tablist" wire:ignore>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#TabDetails" aria-controls="TabDetails" aria-selected="true">
                        <i class="tf-icons bx bx-home"></i> Details
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#TabRooms" aria-controls="TabRooms" aria-selected="false">
                        <i class="tf-icons bx bx-user"></i> Customer
                    </button>
                </li>
            </ul>
            <div class="tab-content" wire:ignore>
                <div class="tab-pane fade " id="TabDetails" role="tabpanel">
                    @livewire('admin.building.view.update-tab',['id'=>$buildings['id']])
                </div>
                <div class="tab-pane fade show active" id="TabRooms" role="tabpanel">
                    @livewire('admin.room.table',['id'=>$buildings['id']])
                </div>
            </div>
        </div>
    </div>
</div>
