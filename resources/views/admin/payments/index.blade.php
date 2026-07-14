@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.payments.title_manage')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="payments-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.payments.id') }}</th>
                    <th>{{ __('cms.payments.user') }}</th>
                    <th>{{ __('cms.payments.amount') }}</th>
                    <th>{{ __('cms.payments.status') }}</th>
                    <th>{{ __('cms.payments.created_at') }}</th>
                    <th class="text-end">{{ __('cms.payments.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.payments.getData') }}",
            type: 'GET',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user', name: 'user' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            {
                data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <a href="/admin/payments/${row.id}" class="btn-action btn-action-edit" title="View"><i class="bi bi-eye-fill"></i></a>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang),
        order: [[0, 'desc']]
    });
});
</script>
@endsection
