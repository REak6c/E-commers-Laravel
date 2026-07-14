@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
    rel="stylesheet">
@endsection

@section('content')

<x-admin.page-header :title="__('cms.products.title_manage')"
    :create-route="route('admin.products.create')"
    :create-label="__('cms.sidebar.products.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="products-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.products.id') }}</th>
                    <th>{{ __('cms.common.image') }}</th>
                    <th>{{ __('cms.products.name') }}</th>
                    <th>{{ __('cms.products.category') }}</th>
                    <th>{{ __('cms.products.price') }}</th>
                    <th>{{ __('cms.products.stock') }}</th>
                    <th>{{ __('cms.products.status') }}</th>
                    <th class="text-end">{{ __('cms.products.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteProductModal" confirm-id="confirmDeleteProduct"
    :title="__('cms.products.confirm_delete')"
    :message="__('cms.products.delete_confirmation')"
    :confirm-label="__('cms.products.delete')"
    :cancel-label="__('cms.products.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php
$datatableLang = __('cms.datatables');
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            // Custom DOM: toolbar row on top, table in middle, footer row on bottom
            dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>' +
                 'rt' +
                 '<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
            ajax: {
                url: "{{ route('admin.products.data') }}",
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                },
                { data: 'name', name: 'name' },
                {
                    data: 'category',
                    name: 'category',
                    orderable: false,
                    searchable: false
                },
                { data: 'price', name: 'price' },
                {
                    data: 'stock',
                    name: 'stock',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var isChecked = data ? 'checked' : '';
                        return `<label class="switch">
                                    <input type="checkbox" class="toggle-status" data-id="${row.id}" ${isChecked}>
                                    <span class="slider round"></span>
                                </label>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<div class="dt-actions">
                                    <a href="/admin/products/${row.id}/edit" class="btn-action btn-action-edit" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button" class="btn-action btn-action-delete" onclick="deleteProduct(${row.id})" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>`;
                    }
                }
            ],
            pageLength: 10,
            language: @json($datatableLang)
        });

        $(document).on('change', '.toggle-status', function() {
            var productId = $(this).data('id');
            var newStatus = $(this).prop('checked') ? 1 : 0;
            updateProductStatus(productId, newStatus);
        });

    });

    let productToDeleteId = null;

    function deleteProduct(id) {
        productToDeleteId = id;
        $('#deleteProductModal').modal('show');

        $('#confirmDeleteProduct').off('click').on('click', function() {
            if (productToDeleteId !== null) {
                $.ajax({
                    url: '{{ route('admin.products.destroy', ':id') }}'.replace(':id', productToDeleteId),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#products-table').DataTable().ajax.reload();
                            showToast('success', response.message);
                            $('#deleteProductModal').modal('hide');
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function(xhr) {
                        showToast('error', 'Error deleting product!');
                        $('#deleteProductModal').modal('hide');
                    }
                });
            }
        });
    }

    function updateProductStatus(id, status) {
        $.ajax({
            url: '{{ route('admin.products.updateStatus') }}',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    $('#products-table').DataTable().ajax.reload();
                    showToast('success', response.message);
                } else {
                    showToast('error', response.message);
                }
            },
            error: function(xhr) {
                showToast('error', "Error updating product status! Please try again.");
            }
        });
    }

</script>

@endsection