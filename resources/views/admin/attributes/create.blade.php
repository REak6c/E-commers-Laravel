@extends('admin.layouts.admin')
@section('title', 'Create Attribute')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Create Attribute' }}</h4>
            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.attributes.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Attribute Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">{{ 'Attribute Name' }}</label>
                        <input type="text" name="name" id="name"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="e.g. Color, Size">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Attribute Values -->
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-semibold mb-0">{{ 'Attribute Values' }}</label>
                            <button type="button" id="add-value" class="btn btn-sm btn-primary shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Add Value
                            </button>
                        </div>

                        <div id="attribute-values-container">
                            @php $oldValues = old('values', ['']); @endphp
                            @foreach ($oldValues as $index => $val)
                            <div class="mb-3 value-group position-relative">
                                <input type="text" name="values[]"
                                    class="form-control border-0 bg-light pe-5 @error('values.' . $index) is-invalid @enderror"
                                    value="{{ $val }}" placeholder="Enter value {{ $index + 1 }}">
                                <button type="button"
                                    class="btn-action-delete position-absolute end-0 top-50 translate-middle-y me-2 remove-value"
                                    title="{{ 'Remove Value' }}">
                                    <i class="bi bi-x-circle text-danger"></i>
                                </button>
                                @error('values.' . $index)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3524/3524659.png" class="mb-4" style="width: 80px; opacity: 0.5;">
                    <p class="text-muted small mb-4">Attributes define product variations like size or color. Add values for a better customer experience.</p>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Save Attribute' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    function updatePlaceholders() {
        document.querySelectorAll("#attribute-values-container .value-group input").forEach((input, i) => {
            input.placeholder = "Enter value " + (i + 1);
        });
    }

    document.getElementById("add-value").addEventListener("click", function () {
        var container = document.getElementById("attribute-values-container");
        var valueGroup = document.createElement("div");
        valueGroup.classList.add("mb-3", "value-group");
        valueGroup.style.position = "relative";

        var valueInput = document.createElement("input");
        valueInput.type = "text";
        valueInput.name = "values[]";
        valueInput.classList.add("form-control", "border-0", "bg-light", "pe-5");

        var removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.classList.add("btn-action-delete", "position-absolute", "end-0", "top-50", "translate-middle-y", "me-2", "remove-value");
        removeBtn.innerHTML = '<i class="bi bi-x-circle text-danger"></i>';

        valueGroup.appendChild(valueInput);
        valueGroup.appendChild(removeBtn);
        container.appendChild(valueGroup);
        updatePlaceholders();
    });

    document.addEventListener("click", function (e) {
        if (e.target.closest(".remove-value")) {
            e.target.closest(".value-group").remove();
            updatePlaceholders();
        }
    });

    updatePlaceholders();
});
</script>
@endsection
