@extends('vendor.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-star me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ 'Product Reviews' }}
        </h1>
        <p class="vp-page-header__sub">Browse and moderate customer reviews for your products.</p>
    </div>
</div>

{{-- Table --}}
<div class="table-responsive">
    <table id="reviews-table" class="table align-middle w-100">
        <thead>
            <tr>
                <th>{{ 'ID' }}</th>
                <th>{{ 'Customer' }}</th>
                <th>{{ 'Product' }}</th>
                <th>{{ 'Rating' }}</th>
                <th>{{ 'Status' }}</th>
                <th class="text-end">{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>
</div>

{{-- Delete Modal --}}
<x-admin.delete-modal id="deleteReviewModal" confirm-id="confirmDeleteReview"
    :title="'Confirm Delete'"
    :message="'Are you sure you want to delete this review?'"
    :confirm-label="'Delete'"
    :cancel-label="'Cancel'" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = null; @endphp

<script>
$(document).ready(function () {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('vendor.reviews.data') }}",
            type: 'GET'
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: d => `<span style="font-weight:700;color:var(--vp-text);">#${d}</span>`
            },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'product_name',  name: 'product_name' },
            {
                data: 'rating', name: 'rating',
                render: d => {
                    const stars = parseInt(d) || 0;
                    let html = '';
                    for (let i = 1; i <= 5; i++) {
                        html += `<i class="fas fa-star" style="font-size:.75rem;color:${i <= stars ? '#f59e0b' : '#e2e8f0'};"></i>`;
                    }
                    return `<span class="d-flex align-items-center gap-1">${html} <span style="font-size:.78rem;color:var(--vp-text-muted);margin-left:3px;">${stars}/5</span></span>`;
                }
            },
            {
                data: 'status', name: 'status',
                orderable: false, searchable: false,
                render: d => d
            },
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<div class="d-flex justify-content-end gap-1">
                        <a href="/vendor/reviews/${row.id}"
                           class="vp-action-btn vp-action-btn--view"
                           title="{{ 'View' }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="vp-action-btn vp-action-btn--delete"
                                onclick="deleteReview(${row.id})"
                                title="{{ 'Delete' }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
            }
        ],
        pageLength: 10,
        language: @json($datatableLang),
    });
});

let reviewToDeleteId = null;

function deleteReview(id) {
    reviewToDeleteId = id;
    $('#deleteReviewModal').modal('show');

    $('#confirmDeleteReview').off('click').on('click', function () {
        if (reviewToDeleteId !== null) {
            $.ajax({
                url: '{{ route('vendor.reviews.destroy', ':id') }}'.replace(':id', reviewToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    $('#reviews-table').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#deleteReviewModal').modal('hide');
                },
                error: function () {
                    toastr.error('Error deleting review.');
                    $('#deleteReviewModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
