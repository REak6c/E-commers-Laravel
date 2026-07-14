@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.menu_items.heading')"
    :create-route="route('admin.menus.items.create', $menu->id)"
    :create-label="__('cms.menu_items.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="menu-items-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.menu_items.id') }}</th>
                    <th>{{ __('cms.menu_items.slug') }}</th>
                    <th>{{ __('cms.menu_items.order_number') }}</th>
                    <th class="text-end">{{ __('cms.menu_items.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteMenuItemModal" confirm-id="confirmDeleteMenuItem"
    :title="__('cms.menu_items.massage_confirm')"
    :message="__('cms.menu_items.confirm_delete')"
    :confirm-label="__('cms.menu_items.massage_delete')"
    :cancel-label="__('cms.menu_items.massage_cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#menu-items-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.menus.item.getData') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}" }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'slug', name: 'slug' },
            { data: 'order_number', name: 'order_number' },
            {
                data: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <a href="/admin/items/${row.id}/edit" class="btn-action btn-action-edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <button type="button" class="btn-action btn-action-delete" onclick="deleteMenuItem(${row.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let menuItemToDeleteId = null;

function deleteMenuItem(id) {
    menuItemToDeleteId = id;
    $('#deleteMenuItemModal').modal('show');
    $('#confirmDeleteMenuItem').off('click').on('click', function() {
        if (menuItemToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.items.destroy', ':id') }}'.replace(':id', menuItemToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#menu-items-table').DataTable().ajax.reload();
                        showToast('success', response.message);
                        $('#deleteMenuItemModal').modal('hide');
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', "Error deleting menu item! Please try again.");
                    $('#deleteMenuItemModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
