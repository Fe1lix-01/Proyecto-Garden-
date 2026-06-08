<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl border border-transparent bg-[#b02f00] px-4 py-2 text-xs font-black uppercase tracking-widest text-white transition hover:bg-[#862200] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-[#ffb5a0] focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
