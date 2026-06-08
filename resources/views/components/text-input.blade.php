@props(['disabled' => false])

<input 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'rounded-xl border-[#e4beb4] bg-white px-4 py-3 shadow-sm focus:border-[#b02f00] focus:ring-[#ffb5a0]']) !!}
>
