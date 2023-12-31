<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <svg class="h-12 w-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                        </svg>
                    </div>
                </div>


                <nav class="mt-10">
                    <a href="{{ route('admin.admin_users.index') }}"
                       class="text-gray-100 flex items-center mt-4 py-2 px-6">

                        <span class="mx-3">Администраторы</span>
                    </a>
                    
                        <a href="{{ route('admin.users') }}"
                       class="text-gray-100 flex items-center mt-4 py-2 px-6">

                        <span class="mx-3">Пользователи</span>
                    </a>
                </nav>
            </div>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen"
                                    class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                                <img class="h-full w-full object-cover"
                                     src="data:image/jpeg;base64,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"
                                     alt="Your avatar">
                            </button>

                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                                 style="display: none;"></div>

                            <div x-show="dropdownOpen"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                                 style="display: none;">
                                <a href="{{ route("admin.logout") }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Выйти</a>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
