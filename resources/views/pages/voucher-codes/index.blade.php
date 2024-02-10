<x-app-layout>
    <div class="pagetitle mb-5">
        <x-button class="btn-primary float-end" type="button">
            <i class="bi bi-plus me-1"></i>
            {{ __('Add a New Voucher') }}
        </x-button>
        <h1>{{ __('Voucher Codes') }}</h1>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-2">
                <x-voucher-card key="1" code="1234567"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">Page 1</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">Page 2</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <x-delete-alert />
</x-app-layout>