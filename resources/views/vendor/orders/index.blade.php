@extends('vendor.layouts.master')

@section('title', 'Orders')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

<x-admin.page-header :title="'Orders'" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="orders-table" class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal
    id="deleteOrderModal"
    confirm-id="confirmDeleteOrder"
    :title="'Confirm Delete'"
    :message="'Are you sure you want to delete this order?'"
    :confirm-label="'Delete'"
    :cancel-label="'Cancel'" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = null; @endphp

<script>
$(function () {
    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('vendor.orders.data') }}",
            type: 'POST',
            data: function (d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: d => `<span class="fw-bold text-body">#${String(d).padStart(5, '0')}</span>`
            },
            {
                data: 'customer', name: 'customer',
                orderable: false, searchable: false
            },
            {
                data: 'order_date', name: 'order_date',
                orderable: false, searchable: false
            },
            {
                data: 'status', name: 'status',
                render: d => {
                    const cls = d ? d.toLowerCase() : '';
                    return `<span class="vp-status-badge ${cls}">${d ?? '—'}</span>`;
                }
            },
            {
                data: 'total_price', name: 'total_price',
                orderable: false, searchable: false,
                render: d => `<span class="fw-semibold">${d}</span>`
            },
            {
                data: 'action', orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<div class="dt-actions">
                        <button type="button"
                                class="btn-action btn-action-delete"
                                onclick="deleteOrder(${row.id})" title="Delete">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>`
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let orderToDeleteId = null;

function deleteOrder(id) {
    orderToDeleteId = id;
    $('#deleteOrderModal').modal('show');
    $('#confirmDeleteOrder').off('click').on('click', function () {
        if (orderToDeleteId !== null) {
            $.ajax({
                url: '{{ route('vendor.orders.destroy', ':id') }}'.replace(':id', orderToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    $('#deleteOrderModal').modal('hide');
                    if (response.success) {
                        $('#orders-table').DataTable().ajax.reload();
                        showToast('success', response.message ?? 'Order deleted successfully.');
                    } else {
                        showToast('error', response.message ?? 'Failed to delete order.');
                    }
                },
                error: function () {
                    $('#deleteOrderModal').modal('hide');
                    showToast('error', 'An error occurred while deleting the order.');
                }
            });
        }
    });
}
</script>
@endsection
