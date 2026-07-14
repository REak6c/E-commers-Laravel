@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.payment_gateways.title_manage')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="gateways-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.payment_gateways.id') }}</th>
                    <th>{{ __('cms.payment_gateways.name') }}</th>
                    <th>{{ __('cms.payment_gateways.status') }}</th>
                    <th class="text-end">{{ __('cms.payment_gateways.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteGatewayModal" confirm-id="confirmDeleteGateway"
    :title="__('cms.payment_gateways.confirm_delete')"
    :message="__('cms.payment_gateways.delete_confirmation')"
    :confirm-label="__('cms.payment_gateways.delete')"
    :cancel-label="__('cms.payment_gateways.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#gateways-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.payment-gateways.getData') }}",
            type: 'GET',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            {
                data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <a href="/admin/payment-gateways/${row.id}/edit" class="btn-action btn-action-edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <button type="button" class="btn-action btn-action-delete" onclick="deleteGateway(${row.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let gatewayToDeleteId = null;

function deleteGateway(id) {
    gatewayToDeleteId = id;
    $('#deleteGatewayModal').modal('show');
    $('#confirmDeleteGateway').off('click').on('click', function() {
        $.ajax({
            url: '{{ route('admin.payment-gateways.destroy', ':id') }}'.replace(':id', gatewayToDeleteId),
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                $('#deleteGatewayModal').modal('hide');
                $('#gateways-table').DataTable().ajax.reload();
                showToast('success', "Gateway deleted successfully");
            },
            error: function() { showToast('error', "Error deleting gateway"); }
        });
    });
}
</script>
@endsection
