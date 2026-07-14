@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.pages.title')"
    :create-route="route('admin.pages.create')"
    :create-label="__('cms.sidebar.pages.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="pagesTable" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.pages.table_title') }}</th>
                    <th>{{ __('cms.pages.table_slug') }}</th>
                    <th>{{ __('cms.pages.table_status') }}</th>
                    <th class="text-end">{{ __('cms.pages.table_actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deletePageModal" confirm-id="confirmDeletePage"
    :title="__('cms.pages.delete_modal_title')"
    :message="__('cms.pages.delete_modal_text')"
    :confirm-label="__('cms.pages.delete_modal_delete')"
    :cancel-label="__('cms.pages.delete_modal_cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
let pageToDeleteId = null;

$(document).ready(function() {
    const table = $('#pagesTable').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.pages.data') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}" }
        },
        columns: [
            { data: 'translated_title', name: 'translated_title' },
            { data: 'slug', name: 'slug' },
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });

    window.deletePage = function(id) {
        pageToDeleteId = id;
        $('#deletePageModal').modal('show');
    };

    $('#confirmDeletePage').off('click').on('click', function() {
        if (!pageToDeleteId) return;
        $.ajax({
            url: '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageToDeleteId),
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", _method: 'DELETE' },
            success: function(response) {
                table.ajax.reload();
                $('#deletePageModal').modal('hide');
                showToast('success', response.message || "{{ __('cms.pages.toastr_success') }}");
            },
            error: function() {
                showToast('error', "{{ __('cms.pages.toastr_error') }}");
                $('#deletePageModal').modal('hide');
            }
        });
    });
});
</script>
@endsection
