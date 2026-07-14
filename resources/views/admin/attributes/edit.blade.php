@extends('admin.layouts.admin')
@section('title', 'Edit Attribute')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.attributes.title_edit') }}</h4>
            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Attribute Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">{{ __('cms.attributes.attribute_name') }}</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $attribute->name) }}"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Attribute Values -->
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-semibold mb-0">{{ __('cms.attributes.attribute_values') }}</label>
                            <button type="button" id="add-value" class="btn btn-sm btn-primary shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Add Value
                            </button>
                        </div>

                        <div id="attribute-values-container">
                            @foreach ($attribute->values as $index => $value)
                            <div class="mb-3 value-group position-relative">
                                <input type="text" name="values[]"
                                    class="form-control border-0 bg-light pe-5 @error('values.' . $index) is-invalid @enderror"
                                    value="{{ old('values.' . $index, $value->value) }}"
                                    placeholder="Enter value">
                                <button type="button"
                                    class="btn-action-delete position-absolute end-0 top-50 translate-middle-y me-2 remove-value"
                                    title="{{ __('cms.attributes.remove_value') }}">
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
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3524/3524659.png" class="mb-4" style="width: 80px; opacity: 0.5;">
                    <p class="text-muted small mb-4">Updating attributes will affect all products using these values.</p>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.attributes.update_attribute') ?? 'Update Attribute' }}
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
