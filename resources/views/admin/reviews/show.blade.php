@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Review Details' }}</h4>
            <div class="d-flex gap-2">
                {{-- Approve / Reject toggle button --}}
                <button id="toggleApproveBtn"
                    class="btn shadow-sm {{ $review->is_approved ? 'btn-warning' : 'btn-success' }}"
                    data-id="{{ $review->id }}"
                    data-approved="{{ $review->is_approved ? '1' : '0' }}">
                    <i class="bi {{ $review->is_approved ? 'bi-x-circle me-1' : 'bi-check-circle me-1' }}"></i>
                    <span id="toggleApproveLabel">{{ $review->is_approved ? 'Reject' : 'Approve' }}</span>
                </button>
                <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-outline-primary shadow-sm">
                    <i class="bi bi-pencil me-1"></i> {{ 'Edit' }}
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ 'Review Content' }}</h6>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Rating' }}
                    </label>
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }} fs-5"></i>
                        @endfor
                        <span class="ms-2 fw-semibold">({{ $review->rating }} / 5.0)</span>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Review' }}
                    </label>
                    <div class="p-3 bg-light rounded-3 border-0">
                        {{ $review->review ?? 'No comment provided.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ 'Customer & Product' }}</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Customer' }}
                    </label>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-secondary"></i>
                        </div>
                        <span class="fw-semibold">{{ optional($review->customer)->name ?? 'Guest' }}</span>
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Product' }}
                    </label>
                    <div class="fw-semibold">
                        {{ $review->product?->name ?? 'N/A' }}
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div>
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Status' }}
                    </label>
                    <div id="statusBadge">
                        @if ($review->is_approved)
                            <span class="badge bg-success px-3 fw-bold">{{ 'Approved' }}</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 fw-bold">{{ 'Pending' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('toggleApproveBtn');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const id = this.dataset.id;

        $.ajax({
            url: '/admin/reviews/' + id + '/toggle-approve',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PATCH',
            },
            success: function (response) {
                if (!response.success) return;

                const isApproved = response.is_approved;

                // Update button appearance
                btn.dataset.approved = isApproved ? '1' : '0';
                btn.className = 'btn shadow-sm ' + (isApproved ? 'btn-warning' : 'btn-success');
                btn.querySelector('i').className = 'bi ' + (isApproved ? 'bi-x-circle me-1' : 'bi-check-circle me-1');
                document.getElementById('toggleApproveLabel').textContent = isApproved
                    ? '{{ 'Reject' }}'
                    : '{{ 'Approve' }}';

                // Update status badge
                document.getElementById('statusBadge').innerHTML = isApproved
                    ? '<span class="badge bg-success px-3 fw-bold">{{ 'Approved' }}</span>'
                    : '<span class="badge bg-warning text-dark px-3 fw-bold">{{ 'Pending' }}</span>';

                showToast('success', response.message);
            },
            error: function () {
                showToast('error', 'Something went wrong.');
            }
        });
    });
});
</script>
@endsection
