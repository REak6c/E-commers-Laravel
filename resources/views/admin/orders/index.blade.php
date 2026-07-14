@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.orders.title')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="orders-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.orders.id') }}</th>
                    <th>{{ __('cms.orders.customer') }}</th>
                    <th>{{ __('cms.orders.order_date') }}</th>
                    <th>{{ __('cms.orders.status') }}</th>
                    <th>{{ __('cms.orders.total_price') }}</th>
                    <th class="text-end">{{ __('cms.orders.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteOrderModal" confirm-id="confirmDeleteOrder"
    :title="__('cms.orders.delete_confirm_title')"
    :message="__('cms.orders.delete_confirm_message')"
    :confirm-label="__('cms.orders.delete_button')"
    :cancel-label="__('cms.orders.delete_cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    const table = $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.orders.data') }}",
            type: 'POST',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'customer', name: 'customer', orderable: false, searchable: true },
            { data: 'order_date', name: 'order_date', orderable: false, searchable: false },
            { data: 'status', name: 'status' },
            { data: 'total_price', name: 'total_price', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });

    let orderToDeleteId = null;

    window.deleteOrder = function(id) {
        orderToDeleteId = id;
        $('#deleteOrderModal').modal('show');
    };

    $('#confirmDeleteOrder').on('click', function() {
        if (orderToDeleteId === null) return;
        $.ajax({
            url: '{{ route("admin.orders.destroy", ":id") }}'.replace(':id', orderToDeleteId),
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res.success) {
                    table.ajax.reload(null, false);
                    showToast('success', res.message);
                    $('#deleteOrderModal').modal('hide');
                    orderToDeleteId = null;
                } else {
                    showToast('error', res.message || 'Failed to delete order');
                }
            },
            error: function() {
                showToast('error', 'An error occurred while deleting the order');
                $('#deleteOrderModal').modal('hide');
            }
        });
    });
});
</script>
@endsection
