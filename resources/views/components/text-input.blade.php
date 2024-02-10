@props([
    'type' => 'text',
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'disabled' => false,
])

<input 
    type="{{ $type }}" 
    id="{{ $id }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'form-control']) !!}
>
