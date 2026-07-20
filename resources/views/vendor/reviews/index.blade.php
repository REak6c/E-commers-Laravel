@extends('vendor.layouts.master')

@section('title', 'Product Reviews')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

<x-admin.page-header :title="'Product Reviews'" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="reviews-table" class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal
    id="deleteReviewModal"
    confirm-id="confirmDeleteReview"
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
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('vendor.reviews.data') }}",
            type: 'GET'
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: d => `<span class="fw-bold text-body">#${d}</span>`
            },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'product_name',  name: 'product_name' },
            {
                data: 'rating', name: 'rating',
                render: d => {
                    const stars = parseInt(d) || 0;
                    let html = '';
                    for (let i = 1; i <= 5; i++) {
                        html += `<i class="bi bi-star-fill" style="font-size:.75rem;color:${i <= stars ? '#f59e0b' : '#e2e8f0'};"></i>`;
                    }
                    return `<span class="d-flex align-items-center gap-1">${html}
                        <span class="text-muted ms-1" style="font-size:.78rem;">${stars}/5</span>
                    </span>`;
                }
            },
            {
                data: 'status', name: 'status',
                orderable: false, searchable: false
            },
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<div class="dt-actions">
                        <a href="/vendor/reviews/${row.id}"
                           class="btn-action btn-action-edit" title="View"
                           style="background:#ecfeff;color:#0891b2;border-color:#a5f3fc;">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <button type="button"
                                class="btn-action btn-action-delete"
                                onclick="deleteReview(${row.id})" title="Delete">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>`
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
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
                    $('#deleteReviewModal').modal('hide');
                    $('#reviews-table').DataTable().ajax.reload();
                    showToast('success', response.message ?? 'Review deleted successfully.');
                },
                error: function () {
                    $('#deleteReviewModal').modal('hide');
                    showToast('error', 'Error deleting review.');
                }
            });
        }
    });
}
</script>
@endsection
