@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Edit Payment Gateway' }}</h4>
            <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            {{-- Gateway Details --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ 'Gateway Information' }}</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">{{ 'Gateway Name' }}</label>
                            <input type="text" name="name" value="{{ old('name', $paymentGateway->name) }}"
                                class="form-control border-0 bg-light" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">{{ 'Code' }}</label>
                            <input type="text" name="code" value="{{ old('code', $paymentGateway->code) }}"
                                class="form-control border-0 bg-light" required>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Description' }}</label>
                        <textarea name="description" class="form-control border-0 bg-light"
                            rows="3">{{ old('description', $paymentGateway->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Configurations --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ 'Configurations' }}</h6>

                    @forelse ($paymentGateway->configs as $config)
                    <div class="bg-light rounded p-4 mb-4">
                        <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">{{ 'Key Name' }}</label>
                                <input type="text" name="configs[{{ $config->id }}][key_name]" value="{{ old("
                                    configs.$config->id.key_name", $config->key_name) }}"
                                class="form-control border-0 bg-white shadow-sm" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">{{ 'Key Value' }}</label>
                                <input type="text" name="configs[{{ $config->id }}][key_value]" value="{{ old("
                                    configs.$config->id.key_value", $config->key_value) }}"
                                class="form-control border-0 bg-white shadow-sm" required>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <x-admin.combobox
                                :name="'configs[' . $config->id . '][environment]'"
                                wrapper-class="col-md-6 mb-3"
                                select-class="form-select border-0 bg-white shadow-sm"
                                :label="'Environment'"
                                :selected="$config->environment"
                                :options="[
                                    'sandbox' => 'Sandbox',
                                    'production' => 'Production',
                                ]" />
                            <div class="col-md-6 mb-3 pb-2">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="configs[{{ $config->id }}][is_encrypted]" value="0">
                                    <input type="checkbox" class="form-check-input"
                                        name="configs[{{ $config->id }}][is_encrypted]" value="1"
                                        id="encrypt_{{ $config->id }}" {{ $config->is_encrypted ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="encrypt_{{ $config->id }}">{{
                                        'Encrypted' }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-gear text-muted display-4 mb-3"></i>
                        <p class="text-muted">{{ 'No configurations found.' }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Status' }}</h6>
                    <div class="form-check form-switch mb-4">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{
                            $paymentGateway->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">{{
                            'Active' }}</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Update Gateway' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection