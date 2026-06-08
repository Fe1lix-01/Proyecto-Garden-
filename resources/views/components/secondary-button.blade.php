<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center rounded-xl border border-[#e4beb4] bg-white px-4 py-2 text-xs font-black uppercase tracking-widest text-[#5b4039] shadow-sm transition hover:bg-[#ffdbd1] focus:outline-none focus:ring-2 focus:ring-[#ffb5a0] focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
