@props([
    'id' => '',
    'name' => '',
    'value' => '',
    'checked' => false,
    'disabled' => false,
])

<div class="form-check form-switch">
    <input 
        type="checkbox" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        {!! $attributes->merge(['class' => 'form-check-input']) !!} 
        {{ $checked ? 'checked' : '' }} 
        {{ $disabled ? 'disabled' : '' }}
    >
        {{ $slot }}
    </label>
</div>