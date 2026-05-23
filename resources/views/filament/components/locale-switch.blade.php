@php
    $nextLocale = app()->getLocale() === 'ar' ? 'en' : 'ar';
@endphp

<a
    href="{{ route('locale.switch', ['locale' => $nextLocale]) }}"
    class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
    title="Switch language"
    aria-label="Switch language"
>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21-.75-3M14.25 21l-.75-3M3 6h18M4.5 6l.75 12h13.5l.75-12M12 6V3m-3 8h6m-6 3h6" />
    </svg>
    <span class="hidden sm:inline"><img src="{{ asset('images/Icon.png') }}" alt="{{ strtoupper($nextLocale) }}" class="h-5 w-5 inline">{{ strtoupper($nextLocale) }}</span>
</a>
