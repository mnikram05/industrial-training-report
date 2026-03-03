{{-- Shared form fields for Create / Edit --}}

<div class="row mb-3">
    <div class="col-md-4">
        <label for="name" class="form-label">{{ __('modules/reference/state.fields.name') }} <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $state->name ?? '') }}" required maxlength="100">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="fullname" class="form-label">@lang('modules/reference/state.fields.fullname')</label>
        <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror"
               value="{{ old('fullname', $state->fullname ?? '') }}" maxlength="255">
        @error('fullname')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="ddsa_code" class="form-label">DDSA Code</label>
        <input type="text" name="ddsa_code" id="ddsa_code" class="form-control @error('ddsa_code') is-invalid @enderror"
               value="{{ old('ddsa_code', $state->ddsa_code ?? '') }}" maxlength="10">
        @error('ddsa_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @isset($state)
    <div class="col-md-4">
        <label for="iso_code" class="form-label">ISO Code</label>
        <input type="text" name="iso_code" id="iso_code" class="form-control @error('iso_code') is-invalid @enderror"
               value="{{ old('iso_code', $state->iso_code ?? '') }}" maxlength="10">
        @error('iso_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="sort" class="form-label">Sort Order</label>
        <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
               value="{{ old('sort', $state->sort ?? 0) }}" min="0">
        @error('sort')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @endisset
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $state->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $state->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
