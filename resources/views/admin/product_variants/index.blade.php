@extends('admin.layouts.admin')

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">{{ __('cms.product_variants.title_manage') }}</h4>
            <a href="{{ route('admin.product_variants.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> {{ __('cms.product_variants.add_new') }}
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <table id="product-variants-table" class="table table-hover align-middle w-100 mt-0">
            <thead>
                <tr>
                    <th class="border-top-0">{{ __('cms.product_variants.col_product') }}</th>
                    <th class="border-top-0">{{ __('cms.product_variants.col_variant_name') }}</th>
                    <th class="border-top-0">{{ __('cms.product_variants.col_price') }}</th>
                    <th class="border-top-0">{{ __('cms.product_variants.col_stock') }}</th>
                    <th class="border-top-0">{{ __('cms.product_variants.col_sku') }}</th>
                    <th class="border-top-0 text-end">{{ __('cms.product_variants.col_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productVariants as $productVariant)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $productVariant->product->name ?? __('cms.product_variants.unknown_product') }}</div>
                    </td>
                    <td>
                        <span>{{ $productVariant->name ?? '—' }}</span>
                    </td>
                    <td><span class="fw-bold text-primary">{{ $productVariant->price }}</span></td>
                    <td>
                        @if($productVariant->stock <= 5)
                            <span class="badge bg-danger-soft text-danger px-3">{{ $productVariant->stock }}</span>
                        @else
                            <span class="badge bg-success-soft text-success px-3">{{ $productVariant->stock }}</span>
                        @endif
                    </td>
                    <td><code class="text-muted small">{{ $productVariant->SKU }}</code></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.product_variants.edit', $productVariant->id) }}"
                                class="btn btn-light btn-sm text-primary shadow-sm me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.product_variants.destroy', $productVariant->id) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('cms.product_variants.delete_confirmation') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm text-danger shadow-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $productVariants->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#product-variants-table').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false
        });
    });
</script>
@endsection
