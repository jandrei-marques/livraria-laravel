@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'required' => false,
    'class' => '',
    'multiple' => false
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }} @if($required) * @endif</label>
    <select
        class="form-control {{ $class }} @error($name) is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        @if($required) required @endif
        @if($multiple) multiple @endif
    >
        @if(!$multiple)
            <option value="">Selecione uma opção</option>
        @endif
        @foreach($options as $key => $option)
            @if($multiple)
                <option value="{{ $key }}" {{ in_array($key, old($name, $value ?? [])) ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @else
                <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>
    @error($name)
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
