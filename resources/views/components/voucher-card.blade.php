<div class="card info-card sales-card">
    <div class="filter">
        <form id="deleteForm{{ $key }}" method="POST" action="{{ route('voucher-codes.destroy', Crypt::encryptString($id)) }}">
            @csrf
            @method('delete')
        
            <button type="button" class="btn icon delete-button" data-id="{{ $key }}">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>        
    </div>

    <div class="card-body">
        <h5 class="card-title">
            {{ __('Voucher') }} <span> {{ __('Code') }}</span>
        </h5>

        <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-card-checklist"></i>
            </div>
            <div class="ps-3">
                <h6>{{ $code }}</h6>
            </div>
        </div>
    </div>
</div> 