<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PermissionProvider extends ServiceProvider
{
    public function register()
    {
        App::bind('permissions', function () {
            return new \App\Library\Helpers\Permissions;
        });
    }

    public function boot()
    {
    }
}
