@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.currencies.title')"
    :create-route="route('admin.currencies.create')"
    :create-label="__('cms.currencies.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="currencies-table" class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('cms.currencies.name') }}</th>
                    <th>{{ __('cms.currencies.code') }}</th>
                    <th>{{ __('cms.currencies.symbol') }}</th>
                    <th>{{ __('cms.currencies.exchange_rate') }}</th>
                    <th class="text-end">{{ __('cms.currencies.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteCurrencyModal" confirm-id="confirmDeleteCurrency"
    :title="__('cms.currencies.confirm_delete') ?? 'Confirm Delete'"
    :message="__('cms.currencies.confirm_delete_msg') ?? 'Are you sure you want to delete this currency?'"
    :confirm-label="__('cms.currencies.delete')"
    :cancel-label="__('cms.currencies.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#currencies-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.currencies.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'symbol', name: 'symbol' },
            { data: 'exchange_rate', name: 'exchange_rate' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

function deleteCurrency(id) {
    $('#deleteCurrencyModal').modal('show');
    $('#confirmDeleteCurrency').off('click').on('click', function() {
        $.ajax({
            url: "{{ route('admin.currencies.index') }}/" + id,
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                $('#deleteCurrencyModal').modal('hide');
                $('#currencies-table').DataTable().ajax.reload();
                showToast('success', res.message);
            }
        });
    });
}
</script>
@endsection
