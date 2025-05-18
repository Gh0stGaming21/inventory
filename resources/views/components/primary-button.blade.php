<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-sky-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-wide hover:bg-sky-700 focus:bg-sky-700 active:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 shadow-md transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
