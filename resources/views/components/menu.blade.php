@php
// Function to check if the menu item has children
$hasChildren = fn($item) => !empty($item['children']);
$getChildren = fn($item) => $item['children'] ?? [];

// Functions to get URL, Target, and Name of the menu item
$getUrl = fn($item) => $item['url'];
$getTarget = fn($item) => $item['target'] ?? '_self'; // Default target is '_self'
$getName = fn($item) => $item['name'];

// Languages
$availableLocales = json_decode(env('APP_AVAILABLE_LOCALES', json_encode(['en' => 'English'])), true);
$currentLocale = app()->getLocale();  // Get current locale
$currentLanguage = $availableLocales[$currentLocale] ?? $availableLocales['en'];
@endphp

<header class="z-50 w-full transition-all duration-300"
    x-data="{
        sidebarOpen: false,
        menuPosition: '{{ $menuPosition ?? "left" }}',
        menuAnimation: '{{ $menuAnimation ?? "left" }}',
        hamburgerPosition: 'top-0 right-0', // Impostato per top-right, puoi cambiarlo a bottom-left, etc.
        hamburgerMargin: 'm-2' // Aggiungi margine
    }"
    x-bind:class="{
        'fixed top-0': window.getComputedStyle(document.documentElement).getPropertyValue('--header-sticky').trim() === '1',
        'bg-transparent': !isScrolled && isHome,
        'bg-neutral-100 dark:bg-neutral-900 shadow-lg': isScrolled || !isHome
    }"
    style="height: var(--header-height);">
    <nav class="h-full px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" :class="{ 'bg-transparent': !isScrolled && isHome }">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ '/' }}" class="text-xl font-bold transition-colors duration-300">
                    @if(!empty($theme['white_logo']) && !empty($theme['color_logo']))
                        <img
                            src="{{ asset('storage/' . $theme['white_logo']) }}"
                            alt="{{ $theme['name'] }}"
                            class="h-8 transition-opacity duration-300"
                            x-show="darkMode === 'dark' || (!isScrolled && isHome)"
                        >
                        <img
                            src="{{ asset('storage/' . $theme['color_logo']) }}"
                            alt="{{ $theme['name'] }}"
                            class="h-8 transition-opacity duration-300"
                            x-show="darkMode !== 'dark' && (isScrolled || !isHome)"
                        >
                    @else
                        <span
                            :class="{
                                'text-white': !isScrolled && isHome,
                                'text-primary dark:text-white': isScrolled || !isHome
                            }"
                        >
                            {{ $theme['name'] }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="items-center hidden space-x-4 md:flex">
                @foreach($menuItems as $item)
                    @if(!($hasChildren($item)))
                        <a href="{{ $getUrl($item) }}"
                            target="{{ $getTarget($item) }}"
                            class="px-3 py-2 text-sm font-medium rounded-md text-secondary hover:bg-primary/10 hover:text-primary">
                            {{ $getName($item) }}
                        </a>
                    @else
                        <div x-data="{
                            open: false,
                            toggle() { this.open = !this.open; }
                        }"
                        class="relative">
                            <button
                                @click="toggle()"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-secondary hover:bg-primary/10 hover:text-primary">
                                {{ $getName($item) }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 z-50 w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-800"
                                style="display: none;">
                                @foreach($getChildren($item) as $child)
                                    <a href="{{ $child['url'] }}"
                                        target="{{ $child['target'] ?? '_self' }}"
                                        class="block px-4 py-2 text-sm rounded-md hover:rounded-md text-secondary hover:bg-primary/10 dark:text-gray-300 dark:hover:bg-gray-700">
                                        {{ $child['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(count($availableLocales) > 1)
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-secondary hover:bg-primary/10 hover:text-primary">
                            {{ $currentLanguage }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 z-50 w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-800"
                            style="display: none;">
                            @foreach($availableLocales as $locale => $language)
                                @if($locale !== $currentLocale)
                                    <a href="{{ route('locale.set', $locale) }}"
                                        class="block px-4 py-2 text-sm text-secondary hover:bg-primary/10 dark:text-gray-300 dark:hover:bg-gray-700">
                                        {{ $language }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mobile menu toggle -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                x-data="{ hamburgerPosition: '{{ $hamburgerPosition ?? 'top-left' }}' }"
                :class="{
                    'top-4 left-4': hamburgerPosition === 'top-left',
                    'top-4 right-4': hamburgerPosition === 'top-right',
                    'bottom-4 left-4': hamburgerPosition === 'bottom-left',
                    'bottom-4 right-4': hamburgerPosition === 'bottom-right'
                }"
                class="fixed z-[100] p-2 text-natural-200 bg-primary rounded-lg shadow-lg transition-all duration-300 ease-in-out md:hidden hover:text-natural-900 dark:bg-primary dark:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile menu backdrop -->
    <div x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-gray-800/50 md:hidden">
    </div>

    <!-- Mobile menu sidebar -->
    <div x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        :x-transition:enter-start="menuAnimation === 'left' ? 'opacity-0 -translate-x-full' : 'opacity-0 translate-x-full'"
        :x-transition:enter-end="'opacity-100 translate-x-0'"
        x-transition:leave="transition ease-in duration-200"
        :x-transition:leave-start="'opacity-100 translate-x-0'"
        :x-transition:leave-end="menuAnimation === 'left' ? 'opacity-0 -translate-x-full' : 'opacity-0 translate-x-full'"
        :class="{
            'left-0': menuPosition === 'left',
            'right-0': menuPosition === 'right'
        }"
        class="fixed top-0 z-50 w-64 h-screen bg-white shadow-lg dark:bg-gray-800">

        <!-- Close button -->
        <button
            @click="sidebarOpen = false"
            class="absolute p-2 text-gray-600 right-2 top-2 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Menu content -->
        <div class="h-full overflow-y-auto">
            @foreach($menuItems as $item)
                <a href="{{ $getUrl($item) }}"
                   target="{{ $getTarget($item) }}"
                   class="block px-4 py-2 text-lg text-white hover:bg-primary/10">
                    {{ $getName($item) }}
                </a>
                @foreach($getChildren($item) as $child)
                    <a href="{{ $child['url'] }}"
                       target="{{ $child['target'] ?? '_self' }}"
                       class="block px-4 py-2 text-sm text-white hover:bg-primary/10">
                        {{ $child['name'] }}
                    </a>
                @endforeach
            @endforeach
        </div>
    </div>
</header>
