@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.shops.title')"
    :create-route="route('admin.shops.create')"
    :create-label="__('cms.shops.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="shops-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.common.id') }}</th>
                    <th>{{ __('cms.shops.logo') }}</th>
                    <th>{{ __('cms.shops.name') }}</th>
                    <th>{{ __('cms.shops.slug') }}</th>
                    <th>{{ __('cms.shops.status') }}</th>
                    <th class="text-end">{{ __('cms.shops.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteShopModal" confirm-id="confirmDeleteShop"
    :title="__('cms.shops.confirm_delete')"
    :message="__('cms.shops.confirm_delete_msg')"
    :confirm-label="__('cms.shops.delete')"
    :cancel-label="__('cms.shops.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#shops-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.shops.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            {
                data: 'logo', name: 'logo', orderable: false, searchable: false,
                render: function(data) {
                    return `<img src="${data}" class="dt-product-thumb" alt="shop logo">`;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'status', name: 'status' },
            {
                data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <a href="/admin/shops/${row.id}/edit" class="btn-action btn-action-edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <button type="button" class="btn-action btn-action-delete" onclick="deleteShop(${row.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let shopToDeleteId = null;

function deleteShop(id) {
    shopToDeleteId = id;
    $('#deleteShopModal').modal('show');
    $('#confirmDeleteShop').off('click').on('click', function() {
        $.ajax({
            url: "{{ route('admin.shops.index') }}/" + shopToDeleteId,
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                $('#deleteShopModal').modal('hide');
                $('#shops-table').DataTable().ajax.reload();
                showToast('success', res.message);
            },
            error: function() { showToast('error', "Error deleting shop"); }
        });
    });
}
</script>
@endsection
