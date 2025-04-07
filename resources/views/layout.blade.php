<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="{{request()->url()}}">
    
    {{-- Preload critical assets --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style">
    
    {{-- Load non-critical CSS asynchronously --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    
    {{-- Load Quicksand font asynchronously --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" media="print" onload="this.media='all'">
    
    <meta name="description" content="@yield('description')">
    <title>@yield('title')</title>
    {{-- Image Optimization --}}
    <link rel="dns-prefetch" href="https://dinhduongtinhthan.com">
    <link rel="preconnect" href="https://dinhduongtinhthan.com">
    <meta http-equiv="Accept-CH" content="DPR, Width, Viewport-Width">
    <meta http-equiv="Accept-CH-Lifetime" content="86400">
    {{-- font family --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    {{-- Open Graph --}}
    <meta property="og:title" content="Dinh Dưỡng Tinh Thần - Sức Khỏe Thân Tâm" />
    <meta property="og:description" content="Cân bằng thân-tâm-trí với bài viết chuyên sâu về sức khỏe tinh thần và dinh dưỡng!" />
    <meta property="og:image" content="https://dinhduongtinhthan.com/storage/uploads/OBX32kJfbe2eRxA1Sspxx0tWHCHOVlISI2rWvnNu.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="720" />   
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:type" content="website" /> 
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:locale" content="vi_VN" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LR27B31KEB"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-LR27B31KEB');
    </script>
    {{-- Critical CSS --}}
    <style>
        /* Add your critical CSS here */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Quicksand', sans-serif;
        }
        .dark {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        /* Add more critical styles as needed */
    </style>
</head>

<body class="font-quicksand transition-colors duration-400 bg-white dark:bg-gray-800 text-text-light dark:text-text-dark flex flex-col min-h-screen">
    <header class="bg-white dark:bg-gray-800 shadow-md w-full relative">
        <nav class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between max-[403px]:justify-center max-[403px]:gap-5">
            <!-- Logo section - always visible -->
            <div class="flex items-center">
                <div class="rounded-2xl px-3 py-1.5 flex items-center space-x-2">
                    <img width="32" height="32" src="{{ asset('favicon-32x32.png') }}" alt="logo dinh dưỡng tinh thần">
                    <a href="/" class="text-lg sm:text-xl font-extrabold text-black dark:text-white hover:text-orange-500 dark:hover:text-orange-500 transition duration-300">
                        Dinh dưỡng tinh thần
                    </a>
                </div>
            </div>
    
            <!-- Desktop navigation - hidden on screens smaller than 1024px -->
            <div class="hidden lg:flex items-center space-x-3">
                <a href="/" class="bg-white dark:bg-gray-800 text-black dark:text-white font-bold hover:bg-green-500 hover:text-white dark:hover:bg-green-500 px-3 py-1.5 rounded-lg shadow-md transition duration-300">Trang chủ</a>
                @yield('navbar')
            </div>
    
            <!-- Action buttons - always visible -->
            <div class="flex items-center space-x-2">
                <!-- Search button/form -->
                <div class="relative">
                    <button 
                        id="searchToggle" aria-label="Tìm kiếm"
                        class="p-2 rounded-full bg-white dark:bg-gray-800 text-orange-600 dark:text-white hover:bg-orange-200 dark:hover:bg-gray-700 transition duration-300"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    
                    <!-- Expandable search form -->
                    <form 
                        id="searchForm"
                        class="absolute right-0 top-full mt-1 z-20 w-64 flex overflow-hidden rounded-lg shadow-lg hidden max-[403px]:left-0 max-[403px]:mx-[-20px]"
                        action="{{ route('search') }}"
                        method="GET"
                    >
                        <input 
                            class="w-full h-10 px-4 py-2 bg-white dark:bg-gray-800 dark:text-white focus:outline-none"
                            name="find" 
                            type="text" 
                            placeholder="Nhập từ khoá tìm kiếm"
                        />
                        <button 
                            class="h-10 w-12 flex items-center justify-center bg-orange-500 text-white hover:bg-orange-600 transition duration-300" 
                            type="submit"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
    
                <!-- Dark mode toggle -->
                <button 
                    id="darkModeToggle" aria-label="Bật tắt darkmode"
                    class="p-2 rounded-full bg-white dark:bg-gray-800 text-orange-600 dark:text-white hover:bg-orange-200 dark:hover:bg-gray-700 transition duration-300"
                >
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
    
                <!-- Mobile menu button - visible on screens smaller than 1024px -->
                <button 
                    id="mobileMenuButton" aria-label="Nút mobile menu"
                    class="lg:hidden p-2 rounded-lg bg-white dark:bg-gray-800 text-orange-600 dark:text-white hover:bg-orange-200 dark:hover:bg-gray-700 transition duration-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    
        <!-- Mobile menu - slides down when active, hidden on screens larger than 1024px -->
        <div 
            id="mobileMenu"
            class="lg:hidden absolute w-full bg-orange-50 dark:bg-orange-900 shadow-lg z-10 transition-all duration-300 ease-in-out max-h-0 opacity-0 -translate-y-2 overflow-y-auto overflow-hidden"
        >
            <div class="flex flex-col px-4 py-3 space-y-2">
                <a href="/" class="bg-white dark:bg-gray-800 text-orange-600 dark:text-white font-bold hover:bg-sky-300 hover:text-white dark:hover:bg-sky-300 px-4 py-2 rounded-lg shadow-md transition duration-300">Trang chủ</a>
                @yield('navbar')
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 text-black dark:text-gray-300 shadow-inner bottom-0 left-0 w-full border-t border-gray-300/20">
        <div class="container mx-auto px-4 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <h3 class="text-xl font-bold">NutriMind</h3>
                    <p class="text-sm">Chăm sóc sức khỏe tận tâm, đồng hành cùng bạn trên hành trình sức khỏe.</p>
                    <p class="text-sm">Chúng tôi mang đến những bài viết chuyên sâu về sức khỏe tinh thần và dinh dưỡng</p>
                </div>
                <div class="text-left md:text-center">
                    <h3 class="text-xl font-bold mb-3">Dinh dưỡng tinh thần</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-secondary-light transition duration-300">Trang chủ</a></li>
                        <li><a href="/feed" class="hover:text-secondary-light transition duration-300">RSS</a></li>
                        <li><a href="/sitemap.xml" class="hover:text-secondary-light transition duration-300">Site Map</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-300/20 text-center text-sm">
                <p>Designed by Dinh dưỡng tinh thần - Powered by Dinh dưỡng tinh thần.</p>
                <p>© 2024 NutriMind. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuButton.addEventListener('click', () => {
            if (mobileMenu.classList.contains('max-h-0')) {
                // Open menu
                mobileMenu.classList.remove('max-h-0', 'opacity-0', '-translate-y-2');
                mobileMenu.classList.add('max-h-60', 'opacity-100', 'translate-y-0');
            } else {
                // Close menu
                mobileMenu.classList.remove('max-h-60', 'opacity-100', 'translate-y-0');
                mobileMenu.classList.add('max-h-0', 'opacity-0', '-translate-y-2');
            }
        });
        
        // Search toggle
        const searchToggle = document.getElementById('searchToggle');
        const searchForm = document.getElementById('searchForm');
        
        searchToggle.addEventListener('click', () => {
            searchForm.classList.toggle('hidden');
            if (!searchForm.classList.contains('hidden')) {
                searchForm.querySelector('input').focus();
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', (event) => {
            if (!searchToggle.contains(event.target) && !searchForm.contains(event.target)) {
                searchForm.classList.add('hidden');
            }
        });
        
        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        
        // Check for saved theme preference or use system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        darkModeToggle.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
</body>

</html>

