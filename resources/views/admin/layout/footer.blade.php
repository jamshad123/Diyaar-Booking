<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©  {{ date('Y') }}
            <a href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '') }}" target="_blank" class="footer-link fw-bolder" hidden>
                {{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}
            </a>
        </div>
        <div>
            @if(env('APP_ENV')=='local')
            <a href="{{ config('variables.documentation') ? config('variables.documentation') : '#' }}" target="_blank" class="footer-link me-4">Documentation</a>
            @endif
        </div>
    </div>
</footer>
