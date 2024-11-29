@php
    $languages = config('app.available_locales');
@endphp
<header
    class="z-50 w-full transition-all duration-300"
    x-bind:class="{
        'fixed top-0': window.getComputedStyle(document.documentElement).getPropertyValue('--header-sticky').trim() === '1',
        'bg-transparent': !isScrolled && isHome,
        'bg-neutral-100 dark:bg-neutral-900 shadow-lg': isScrolled || !isHome
    }"
    style="height: var(--header-height);"
>
    <nav class="h-full px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" :class="{ 'bg-transparent': !isScrolled && isHome }">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ '/' }}" class="text-xl font-bold transition-colors duration-300">
                    @if(isset($theme['white_logo']) && isset($theme['color_logo']))
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
            <div class="hidden md:block">
                <div class="flex items-center space-x-4">
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
                                timeout: null,
                                toggle() { this.open = true; },
                                close() {
                                    this.timeout = setTimeout(() => {
                                        this.open = false;
                                    }, 150);
                                },
                                cancelClose() {
                                    if (this.timeout) clearTimeout(this.timeout);
                                }
                            }"
                            class="relative"
                            @mouseleave="close()">
                                <button
                                    @mouseenter="toggle()"
                                    class="px-3 py-2 text-sm font-medium rounded-md text-secondary hover:bg-primary/10 hover:text-primary"
                                >
                                    {{ $getName($item) }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <!-- Level 2 Dropdown menu -->
                                <div x-show="open"
                                    @mouseenter="cancelClose()"
                                    @mouseleave="close()"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute left-0 z-50 w-48 mt-0 bg-white rounded-lg shadow-lg dark:bg-gray-800"
                                    style="display: none;">
                                    @foreach($getChildren($item) as $child)
                                        <a href="{{ $child['url'] }}"
                                           target="{{ $child['target'] }}"
                                           class="block px-4 py-2 text-sm text-secondary hover:bg-primary/10 dark:text-gray-300 dark:hover:bg-gray-700">
                                            {{ $child['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                <!-- Desktop Language Selector -->
                @if(count($languages) > 1)
                <div x-data="{
                    open: false,
                    timeout: null,
                    toggle() { this.open = true; },
                    close() {
                        this.timeout = setTimeout(() => {
                            this.open = false;
                        }, 150);
                    },
                    cancelClose() {
                        if (this.timeout) clearTimeout(this.timeout);
                    }
                }"
                class="relative"
                @mouseleave="close()">
                    <button
                        @mouseenter="toggle()"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-secondary hover:bg-primary/10 hover:text-primary"
                    >
                        <span>{{ $languages[app()->getLocale()] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Language dropdown -->
                    <div x-show="open"
                        @mouseenter="cancelClose()"
                        @mouseleave="close()"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-50 w-48 mt-0 bg-white rounded-lg shadow-lg dark:bg-gray-800"
                        style="display: none;">
                        @foreach($languages as $lang => $language)
                            <a href="{{ route('locale.set', ['locale' => $lang]) }}"
                                class="block px-4 py-2 text-sm text-secondary hover:bg-primary/10 dark:text-gray-300 dark:hover:bg-gray-700">
                                {{ $language }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile menu with backdrop -->
<div
    x-cloak
    x-show="sidebarOpen"
    class="fixed inset-0 z-40 md:hidden"
>
    <!-- Unified backdrop and panel container -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.outside="sidebarOpen = false"
        class="relative flex h-full"
    >
        <!-- Backdrop -->
        <div
            class="fixed inset-0 bg-black/30 backdrop-blur-sm"
            @click="sidebarOpen = false"
        ></div>

        <!-- Menu panel -->
        <div
            class="relative flex flex-col w-[280px] h-full max-w-xs bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-transform duration-300"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                <h2 class="text-xl font-semibold">{{ $theme['name'] }}</h2>
                <button
                    @click="sidebarOpen = false"
                    class="p-2 -mr-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800"
                >
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        <!-- Menu items -->
        <div class="flex-1 px-2 pb-4 overflow-y-auto">
            @foreach($menuItems as $item)

                @if(!$hasChildren($item))
                    <a href="{{ $item['url'] }}"
                        target="{{ $item['target'] }}"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium transition-colors duration-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        {{ $item['name'] }}
                    </a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium transition-colors duration-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                        >
                            <span>{{ $item['name'] }}</span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Level 2 menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="px-2 mt-1 space-y-1">
                            @foreach($getChildren($item) as $child)
                                <a href="{{ $child['url'] }}"
                                    target="{{ $child['target'] }}"
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-300 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    {{ $child['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Mobile Language Selector -->
            @if(count($languages) > 1)
                <div x-data="{ open: false }" class="relative mt-4">
                    <button
                        @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium transition-colors duration-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                    >
                        <span>{{ $languages[app()->getLocale()] }}</span>
                        <svg
                            class="w-4 h-4 ml-2 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="px-2 mt-1 space-y-1"
                >
                    @foreach($languages as $lang => $language)

                            href="{{ url('locale/' . $lang) }}"
                            class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-300 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
                        >
                            {{ $language }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
</div>
</div>
</nav>
</header>
