@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.customers.title_manage')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="customers-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.customers.id') }}</th>
                    <th>{{ __('cms.customers.name') }}</th>
                    <th>{{ __('cms.customers.email') }}</th>
                    <th>{{ __('cms.customers.phone') }}</th>
                    <th class="text-end">{{ __('cms.customers.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteCustomerModal" confirm-id="confirmDeleteCustomer"
    :title="__('cms.customers.confirm_delete')"
    :message="__('cms.customers.delete_confirmation')"
    :confirm-label="__('cms.customers.delete')"
    :cancel-label="__('cms.customers.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.customers.data') }}",
            type: 'POST',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            {
                data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <button type="button" class="btn-action btn-action-delete" onclick="deleteCustomer(${row.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let customerToDeleteId = null;

function deleteCustomer(id) {
    customerToDeleteId = id;
    $('#deleteCustomerModal').modal('show');
    $('#confirmDeleteCustomer').off('click').on('click', function() {
        $.ajax({
            url: '{{ route('admin.customers.destroy', ':id') }}'.replace(':id', customerToDeleteId),
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                $('#deleteCustomerModal').modal('hide');
                $('#customers-table').DataTable().ajax.reload();
                showToast('success', "Customer deleted successfully");
            },
            error: function() { showToast('error', "Error deleting customer"); }
        });
    });
}
</script>
@endsection
