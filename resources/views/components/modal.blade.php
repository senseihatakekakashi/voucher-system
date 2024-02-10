<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered {{$size}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>