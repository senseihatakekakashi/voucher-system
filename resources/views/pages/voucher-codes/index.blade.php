<x-app-layout>
    <div class="pagetitle mb-5">
        <form method="POST" action="{{ route('voucher-codes.store') }}">
            @csrf
            <x-button class="btn-primary float-end">
                <i class="bi bi-plus me-1"></i>
                {{ __('Add a New Voucher') }}
            </x-button>
        </form>
        <h1>{{ __('Voucher Codes') }}</h1>
        @if(session('status'))
            <x-max-voucher-error-alert />
        @endif
    </div>

    <section class="section dashboard">
        <div class="row d-flex justify-content-center">
            @if ($voucher_codes->isNotEmpty())
                @foreach ($voucher_codes as $key => $item)
                    <div class="col-12 col-xl-2">
                        <x-voucher-card :id="$item->id" :key="$key" :code="$item->voucher_code"/>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="{{ route('voucher-codes.index', 'page=' . 1) }}">Page 1</a></li>
                        <li class="page-item"><a class="page-link" href="{{ route('voucher-codes.index', 'page=' . 2) }}">Page 2</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <x-delete-alert />
</x-app-layout>