@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-bold text-[#5b4039]']) }}>
    {{ $value ?? $slot }}
</label>
