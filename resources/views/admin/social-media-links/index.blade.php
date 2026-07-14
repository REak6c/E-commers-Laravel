@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="__('cms.social_media_links.title_manage')"
    :create-route="route('admin.social-media-links.create')"
    :create-label="__('cms.social_media_links.add_new')" />

<x-admin.data-card>
    <div class="table-responsive">
        <table id="social-links-table" class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cms.social_media_links.id') }}</th>
                    <th>{{ __('cms.social_media_links.platform') }}</th>
                    <th>{{ __('cms.social_media_links.url') }}</th>
                    <th>{{ __('cms.social_media_links.status') }}</th>
                    <th class="text-end">{{ __('cms.social_media_links.action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</x-admin.data-card>

<x-admin.delete-modal id="deleteLinkModal" confirm-id="confirmDeleteLink"
    :title="__('cms.social_media_links.confirm_delete')"
    :message="__('cms.social_media_links.delete_confirmation')"
    :confirm-label="__('cms.social_media_links.delete')"
    :cancel-label="__('cms.social_media_links.cancel')" />

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@php $datatableLang = __('cms.datatables'); @endphp

<script>
$(document).ready(function() {
    $('#social-links-table').DataTable({
        processing: true,
        serverSide: true,
        dom: '<"dt-toolbar"<"dt-toolbar__left"l><"dt-toolbar__right"f>>rt<"dt-footer"<"dt-footer__info"i><"dt-footer__paging"p>>',
        ajax: {
            url: "{{ route('admin.social-media-links.data') }}",
            type: 'POST',
            data: function(d) { d._token = "{{ csrf_token() }}"; }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'platform', name: 'platform' },
            {
                data: 'link', name: 'link',
                render: function(data) {
                    return `<a href="${data}" target="_blank" class="text-muted small text-decoration-none">${data}</a>`;
                }
            },
            { data: 'status', name: 'status' },
            {
                data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, row) {
                    return `<div class="dt-actions">
                        <a href="/admin/social-media-links/${row.id}/edit" class="btn-action btn-action-edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <button type="button" class="btn-action btn-action-delete" onclick="deleteLink(${row.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang)
    });
});

let linkToDeleteId = null;

function deleteLink(id) {
    linkToDeleteId = id;
    $('#deleteLinkModal').modal('show');
    $('#confirmDeleteLink').off('click').on('click', function() {
        $.ajax({
            url: '{{ route('admin.social-media-links.destroy', ':id') }}'.replace(':id', linkToDeleteId),
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                $('#deleteLinkModal').modal('hide');
                $('#social-links-table').DataTable().ajax.reload();
                showToast('success', "Link deleted successfully");
            },
            error: function() { showToast('error', "Error deleting link"); }
        });
    });
}
</script>
@endsection
