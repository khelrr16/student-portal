<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
