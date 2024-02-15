<x-app-layout>
    <!-- Page Title and Add New Voucher Button -->
    <div class="pagetitle mb-5">
        <x-button class="btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#add-new-group">
            <i class="bi bi-plus me-1"></i>
            {{ __('Add a New Voucher') }}
        </x-button>
        <h1>{{ __('Voucher Codes') }}</h1>

        <!-- Display Max Voucher Error Alert -->
        @if(session('status'))
            <x-max-voucher-error-alert />
        @endif
    </div>

    <!-- Voucher Codes Section -->
    <section class="section dashboard">
        <div class="row d-flex justify-content-center">
            <!-- Display Voucher Cards -->
            @if ($voucher_codes->isNotEmpty())
                @foreach ($voucher_codes as $key => $item)
                    <div class="col-12 col-xl-2">
                        <x-voucher-card :id="$item->id" :key="$key" :code="$item->voucher_code"/>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    {{$voucher_codes->onEachSide(1)->links()}}
                </nav>
            </div>
        </div>
    </section>

    <!-- Add New Group Modal -->
    <x-modal id="add-new-group" title="Create Vouchers" size="modal-md">
        <div class="card p-4 m-4">
            <div class="card-body">
                <!-- Form for Generating Voucher Codes -->
                <form method="POST" action="{{ route('voucher-codes.store') }}">
                    @csrf
                    <div class="col-12 mb-3">
                        <x-input-label for="quantity" :value="__('Number of Voucher Codes to generate?')" />
                        <x-text-input id="quantity" type="number" name="quantity" :value="old('quantity')" min="1" max="10" required autofocus autocomplete="quantity" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    
                    <div class="col-12">
                        <!-- Save Button -->
                        <x-button class="btn-primary w-100">
                            {{ __('Create Vouchers') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
        <small class="mt-3"><span class="text-danger fw-bold">Note:</span>You can only generate maximum of (10) Ten Voucher Codes</small>
    </x-modal>

    <!-- Delete Alert Modal -->
    <x-delete-alert />
</x-app-layout>