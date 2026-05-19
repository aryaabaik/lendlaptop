<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LendLaptop') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Inter'] antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 z-50 h-16 w-full bg-[#0A1628] shadow-lg">
        <div class="mx-auto flex h-full max-w-7xl items-center justify-between px-6">
            <!-- Logo -->
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#0D9F7A]">
                    <i class="ti ti-device-laptop text-xl text-white"></i>
                </div>
                <span class="text-lg font-bold text-white">LendLaptop</span>
            </a>

            <!-- Center Navigation Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('user.dashboard') }}" 
                   class="rounded-md px-4 py-2 text-sm font-medium transition-all {{ request()->routeIs('user.dashboard') ? 'bg-[#0D9F7A]/20 text-teal-300 underline decoration-[#0D9F7A] decoration-2 underline-offset-4' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    Dashboard
                </a>
                <span class="text-gray-600">|</span>
                <a href="{{ route('user.laptops.index') }}" 
                   class="rounded-md px-4 py-2 text-sm font-medium transition-all {{ request()->routeIs('user.laptops.*') ? 'bg-[#0D9F7A]/20 text-teal-300 underline decoration-[#0D9F7A] decoration-2 underline-offset-4' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    Pinjam Laptop
                </a>
                <span class="text-gray-600">|</span>
                <a href="{{ route('user.borrowings.index') }}" 
                   class="rounded-md px-4 py-2 text-sm font-medium transition-all {{ request()->routeIs('user.borrowings.*') ? 'bg-[#0D9F7A]/20 text-teal-300 underline decoration-[#0D9F7A] decoration-2 underline-offset-4' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    Peminjaman Saya
                </a>
            </div>

            <!-- User Info & Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:bg-gray-700/50">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->kelas ?? 'Siswa' }}</p>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0D9F7A] text-sm font-semibold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <i class="ti ti-chevron-down text-sm text-gray-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl border border-gray-100 bg-white shadow-lg"
                     style="display: none;">
                    <div class="p-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50">
                            <i class="ti ti-user text-lg text-gray-500"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('user.history') }}" 
                           class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50">
                            <i class="ti ti-history text-lg text-gray-500"></i>
                            <span>Riwayat</span>
                        </a>
                        <hr class="my-2 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-red-600 transition-all hover:bg-red-50">
                                <i class="ti ti-logout text-lg"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden border-t border-gray-700/50 bg-[#0A1628]" x-data="{ mobileOpen: false }">
            <button @click="mobileOpen = !mobileOpen" 
                    class="flex w-full items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-gray-300">
                <span>Menu</span>
                <i class="ti ti-chevron-down text-xs transition-transform" :class="{ 'rotate-180': mobileOpen }"></i>
            </button>
            
            <div x-show="mobileOpen" 
                 x-transition
                 class="border-t border-gray-700/50 bg-[#0A1628] px-4 py-2"
                 style="display: none;">
                <a href="{{ route('user.dashboard') }}" 
                   class="block rounded-md px-4 py-2.5 text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-[#0D9F7A]/20 text-teal-300' : 'text-gray-300 hover:bg-gray-700/50' }}">
                    Dashboard
                </a>
                <a href="{{ route('user.laptops.index') }}" 
                   class="block rounded-md px-4 py-2.5 text-sm font-medium {{ request()->routeIs('user.laptops.*') ? 'bg-[#0D9F7A]/20 text-teal-300' : 'text-gray-300 hover:bg-gray-700/50' }}">
                    Pinjam Laptop
                </a>
                <a href="{{ route('user.borrowings.index') }}" 
                   class="block rounded-md px-4 py-2.5 text-sm font-medium {{ request()->routeIs('user.borrowings.*') ? 'bg-[#0D9F7A]/20 text-teal-300' : 'text-gray-300 hover:bg-gray-700/50' }}">
                    Peminjaman Saya
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 pt-16">
        <!-- Flash Messages -->
        @if(session('success'))
            <div id="flash-success" class="mx-auto mt-6 max-w-7xl px-6">
                <div class="flex items-center gap-3 rounded-full bg-[#0D9F7A]/10 border border-[#0D9F7A]/20 px-5 py-3 text-sm text-[#0D9F7A]">
                    <i class="ti ti-circle-check text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-error" class="mx-auto mt-6 max-w-7xl px-6">
                <div class="flex items-center gap-3 rounded-full bg-red-50 border border-red-200 px-5 py-3 text-sm text-red-600">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0A1628] py-6">
        <p class="text-center text-sm text-gray-400">
            © 2026 UNIBI · LendLaptop
        </p>
    </footer>

    <!-- Auto-dismiss flash messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('flash-success');
            const errorAlert = document.getElementById('flash-error');
            
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.3s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 300);
                }, 3000);
            }
            
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.3s ease-out';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 300);
                }, 3000);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
