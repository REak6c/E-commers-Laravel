@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Edit Review' }}</h4>
            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Rating --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Rating' }}</label>
                        <div id="editStarWrapper" class="d-flex gap-2 fs-3" style="cursor:pointer;">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="edit-star" data-value="{{ $i }}"
                                    style="color: {{ $i <= $review->rating ? 'gold' : '#ccc' }};">&#9733;</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="editRatingInput" value="{{ old('rating', $review->rating) }}">
                        @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Review text --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Review' }}</label>
                        <textarea name="review" class="form-control @error('review') is-invalid @enderror"
                            rows="5">{{ old('review', $review->review) }}</textarea>
                        @error('review')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Approval status --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Status' }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                name="is_approved" id="isApprovedSwitch" value="1"
                                {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isApprovedSwitch">
                                {{ 'Approved' }}
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> {{ 'Save' }}
                        </button>
                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-outline-secondary px-4">
                            {{ 'Cancel' }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar: review meta --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ 'Customer & Product' }}</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Customer' }}
                    </label>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                            style="width: 36px; height: 36px;">
                            <i class="bi bi-person text-secondary"></i>
                        </div>
                        <span class="fw-semibold">{{ optional($review->customer)->name ?? 'Guest' }}</span>
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div>
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                        {{ 'Product' }}
                    </label>
                    <div class="fw-semibold">{{ $review->product?->name ?? 'N/A' }}</div>
                </div>

                <hr class="my-3 opacity-25">

                <div>
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">Submitted</label>
                    <div class="text-muted small">{{ $review->created_at?->format('M j, Y \a\t g:i A') ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#editStarWrapper .edit-star');
    const ratingInput = document.getElementById('editRatingInput');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const val = parseInt(this.dataset.value);
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.value) <= val ? 'gold' : '#ccc';
            });
        });

        star.addEventListener('mouseout', function () {
            const current = parseInt(ratingInput.value) || 0;
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.value) <= current ? 'gold' : '#ccc';
            });
        });

        star.addEventListener('click', function () {
            const val = parseInt(this.dataset.value);
            ratingInput.value = val;
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.value) <= val ? 'gold' : '#ccc';
            });
        });
    });
});
</script>
@endsection
