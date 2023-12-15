<div>
    <h5 class="card-header">Change Password</h5>
    <form wire:submit.prevent="save">
        <div class="alert alert-warning" role="alert">
            <h6 class="alert-heading fw-bold mb-1">Ensure that these requirements are met</h6>
            <span>Minimum 6 characters long</span> <br>
            @error('password_confirmation') <span>{{ $message }} <br> </span> @enderror
            @error('password') <span>{{ $message }} <br> </span> @enderror
        </div>
        <div class="row">
            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                <label class="form-label" for="newPassword">New Password</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" type="password" wire:model="password" id="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>
            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" type="password" wire:model="password_confirmation" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary me-2">Change Password</button>
            </div>
        </div>
    </form>
</div>