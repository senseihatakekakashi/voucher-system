@props([
    'id' => '',
    'name' => '',
    'value' => '',
    'checked' => false,
    'disabled' => false,
])

<div class="form-check">
    <input 
        type="radio" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        {!! $attributes->merge(['class' => 'form-check-input']) !!} 
        {{ $checked ? 'checked' : '' }} 
        {{ $disabled ? 'disabled' : '' }}
    >
    <label class="form-check-label" for="{{ $id }}">
        {{ $slot }}
    </label>
</div>