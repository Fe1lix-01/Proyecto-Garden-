<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl border border-transparent bg-[#ba1a1a] px-4 py-2 text-xs font-black uppercase tracking-widest text-white transition hover:bg-[#93000a] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
