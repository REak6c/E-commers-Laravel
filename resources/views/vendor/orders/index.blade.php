@extends('vendor.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-shopping-bag me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ __('cms.orders.title') }}
        </h1>
        <p class="vp-page-header__sub">Track and manage all orders placed in your store.</p>
    </div>
</div>

{{-- Table --}}
<div class="table-responsive">
    <table id="orders-table" class="table align-middle w-100">
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

{{-- Delete Modal --}}
<x-admin.delete-modal id="deleteOrderModal" confirm-id="confirmDeleteOrder"
    :title="__('cms.orders.delete_confirm_title')"
    :message="__('cms.orders.delete_confirm_message')"
    :confirm-label="__('cms.orders.delete_button')"
    :cancel-label="__('cms.orders.delete_cancel')" />

@endsection

@section('js')
@php $datatableLang = __('cms.datatables'); @endphp

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.orders.success') }}", {
        closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
    });
</script>
@endif

<script>
$(function () {
    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('vendor.orders.data') }}",
            type: 'POST',
            data: function (d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: d => `<span style="font-weight:700;color:var(--vp-text);">#${String(d).padStart(5,'0')}</span>`
            },
            { data: 'customer', name: 'customer', orderable: false, searchable: false },
            { data: 'order_date', name: 'order_date', orderable: false, searchable: false },
            {
                data: 'status', name: 'status',
                render: d => `<span class="vp-status-badge ${d ? d.toLowerCase() : ''}">${d ?? '—'}</span>`
            },
            {
                data: 'total_price', name: 'total_price', orderable: false, searchable: false,
                render: d => `<strong style="color:var(--vp-text);">${d}</strong>`
            },
            {
                data: 'action', orderable: false, searchable: false,
                render: (data, type, row) =>
                    `<div class="d-flex justify-content-end gap-1">
                        <button class="vp-action-btn vp-action-btn--delete"
                                onclick="deleteOrder(${row.id})"
                                title="{{ __('cms.orders.delete_button') }}">
                            <i class="fas fa-trash"></i>
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
                    if (response.success) {
                        $('#orders-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.orders.success') }}", {
                            closeButton: true, progressBar: true,
                            positionClass: "toast-top-right", timeOut: 5000
                        });
                    } else {
                        toastr.error(response.message || 'Failed to delete order.');
                    }
                    $('#deleteOrderModal').modal('hide');
                },
                error: function () {
                    toastr.error('An error occurred while deleting the order.');
                    $('#deleteOrderModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
