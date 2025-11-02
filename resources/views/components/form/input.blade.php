@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'maxlength' => null,
    'class' => '',
    'mask' => null
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }} @if($required) * @endif</label>
    <input
        type="{{ $type }}"
        class="form-control {{ $class }} @error($name) is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($mask) data-mask="{{ $mask }}" @endif
    >
    @error($name)
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
