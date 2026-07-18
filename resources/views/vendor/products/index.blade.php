@extends('vendor.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-box-open me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ 'Manage Products' }}
        </h1>
        <p class="vp-page-header__sub">Manage your product catalogue — edit, toggle status, or remove listings.</p>
    </div>
    <div class="vp-page-header__actions">
        <a href="{{ route('vendor.products.create') }}" class="vp-btn-primary">
            <i class="fas fa-plus"></i> {{ 'Add New' }}
        </a>
    </div>
</div>

{{-- Table --}}
<div class="table-responsive">
    <table id="products-table" class="table align-middle w-100">
        <thead>
            <tr>
                <th>{{ 'ID' }}</th>
                <th>{{ 'Name' }}</th>
                <th>{{ 'Price' }}</th>
                <th>{{ 'Status' }}</th>
                <th class="text-end">{{ 'Action' }}</th>
            </tr>
        </thead>
    </table>
</div>

{{-- Delete Modal --}}
<x-admin.delete-modal id="deleteProductModal" confirm-id="confirmDeleteProduct"
    :title="'Confirm Delete'"
    :message="'Are you sure you want to delete this product?'"
    :confirm-label="'Delete'"
    :cancel-label="'Cancel'" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@php $datatableLang = null; @endphp

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ 'Success' }}", {
        closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function () {
    const table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('vendor.products.data') }}",
            type: 'POST',
            data: function (d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: d => `<span style="font-weight:700;color:var(--vp-text);">#${d}</span>`
            },
            {
                data: 'name', name: 'name',
                render: d => `<span style="font-weight:600;color:var(--vp-text);">${d}</span>`
            },
            {
                data: 'price', name: 'price',
                render: d => `<span style="font-weight:600;color:#0f172a;">${d}</span>`
            },
            {
                data: 'status', name: 'status',
                orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<label class="switch">
                        <input type="checkbox" class="toggle-status" data-id="${row.id}" ${data ? 'checked' : ''}>
                        <span class="slider round"></span>
                    </label>`
            },
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<div class="d-flex justify-content-end gap-1">
                        <a href="/vendor/products/${row.id}/edit"
                           class="vp-action-btn vp-action-btn--edit"
                           title="{{ 'Edit' }}">
                            <i class="fas fa-pencil"></i>
                        </a>
                        <button class="vp-action-btn vp-action-btn--delete"
                                onclick="deleteProduct(${row.id})"
                                title="{{ 'Delete' }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
            }
        ],
        pageLength: 10,
        language: @json($datatableLang),
    });

    $(document).on('change', '.toggle-status', function () {
        updateProductStatus($(this).data('id'), $(this).prop('checked') ? 1 : 0);
    });
});

let productToDeleteId = null;

function deleteProduct(id) {
    productToDeleteId = id;
    $('#deleteProductModal').modal('show');

    $('#confirmDeleteProduct').off('click').on('click', function () {
        if (productToDeleteId !== null) {
            $.ajax({
                url: '{{ route('vendor.products.destroy', ':id') }}'.replace(':id', productToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    $('#products-table').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#deleteProductModal').modal('hide');
                },
                error: function () {
                    toastr.error('Error deleting product.');
                    $('#deleteProductModal').modal('hide');
                }
            });
        }
    });
}

function updateProductStatus(id, status) {
    $.ajax({
        url: '{{ route('vendor.products.updateStatus') }}',
        method: 'POST',
        data: { _token: "{{ csrf_token() }}", id: id, status: status },
        success: function (response) { toastr.success(response.message); },
        error: function () { toastr.error("Failed to update status."); }
    });
}
</script>
@endsection
