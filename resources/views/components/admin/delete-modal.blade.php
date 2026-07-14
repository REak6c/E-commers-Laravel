@props([
    'id',
    'confirmId',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmLabel' => 'Delete',
    'cancelLabel' => 'Cancel',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="admin-delete-modal__icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h5 class="fw-bold mb-2">{{ $title }}</h5>
                <p class="text-muted mb-0">{{ $message }}</p>
            </div>
            <div class="modal-footer border-top-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">{{ $cancelLabel }}</button>
                <button type="button" class="btn btn-danger px-4" id="{{ $confirmId }}">{{ $confirmLabel }}</button>
            </div>
        </div>
    </div>
</div>
