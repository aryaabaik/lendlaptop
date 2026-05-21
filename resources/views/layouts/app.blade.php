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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-teal': '#0D9F7A',
                        'navy-navbar': '#0A1628',
                        'status-blue': '#2563EB',
                        'status-amber': '#F59E0B',
                        'status-red': '#EF4444',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Inter'] antialiased text-[#1e293b] bg-gray-50">
    <div x-data="{ mobileSidebarOpen: false, userMenuOpen: false }">
        <!-- NAVBAR -->
        <nav class="fixed top-0 left-0 w-full z-50 h-16 bg-[#0A1628] border-b border-white/5 flex items-center justify-between px-6">
            
            <!-- KIRI — Logo -->
            <div class="flex items-center gap-3">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="mobileSidebarOpen = true" class="md:hidden text-[#9ca3af] hover:text-white focus:outline-none">
                    <i class="ti ti-menu-2 text-2xl"></i>
                </button>

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 text-decoration-none">
                    <div class="w-8 h-8 bg-[#0D9F7A] rounded-lg flex items-center justify-center shadow-sm">
                        <i class="ti ti-device-laptop text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-white font-medium text-[15px]">LendLaptop</span>
                        <span class="text-[#9FE1CB] text-xs font-semibold">UNIBI</span>
                    </div>
                </a>
            </div>

            <!-- TENGAH — Menu Navigasi (Desktop Only) -->
            <div class="hidden md:flex items-center gap-1">
                <!-- Link 1: Dashboard -->
                <a href="{{ route('user.dashboard') }}" 
                   class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.dashboard') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/10 hover:text-white' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Link 2: Pinjam Laptop -->
                <a href="{{ route('user.laptops.index') }}" 
                   class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.laptops.*') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/10 hover:text-white' }}">
                    <i class="ti ti-device-laptop"></i>
                    <span>Pinjam Laptop</span>
                </a>

                <!-- Link 3: Peminjaman Saya -->
                <a href="{{ route('user.borrowings.index') }}" 
                   class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.borrowings.*') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/10 hover:text-white' }}">
                    <i class="ti ti-clipboard-list"></i>
                    <span>Peminjaman Saya</span>
                </a>
            </div>

            <!-- KANAN — Info User -->
            <div class="flex items-center gap-4">
                {{-- NOTIFICATION BELL --}}
                <div class="relative" x-data="notificationDropdown()">
                    {{-- Tombol lonceng --}}
                    <button @click="open = !open; if(open) fetchNotifications()" class="relative text-[#9ca3af] hover:text-white transition-colors focus:outline-none bg-transparent border-none cursor-pointer flex items-center justify-center p-1">
                        <i class="ti ti-bell text-lg"></i>
                        <template x-if="unreadCount > 0">
                            <span class="absolute -top-1 -right-1 bg-[#EF4444] text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-[#0A1628]" x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                        </template>
                    </button>

                    {{-- Dropdown panel --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl border border-gray-100 shadow-xl z-50 py-2"
                         style="display: none;">
                        
                        <div class="flex items-center justify-between px-4 pb-2 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-800">Notifikasi</span>
                            <button x-show="unreadCount > 0" @click="markAllRead()" class="text-xs text-[#0D9F7A] hover:underline bg-transparent border-none cursor-pointer">Tandai semua dibaca</button>
                        </div>

                        <div class="max-h-64 overflow-y-auto" style="scrollbar-width: thin;">
                            <template x-if="notifications.length === 0">
                                <div class="px-4 py-6 text-center text-gray-400 text-xs">
                                    Tidak ada notifikasi.
                                </div>
                            </template>
                            <template x-for="notif in notifications" :key="notif.id">
                                <div class="px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 flex flex-col gap-1 cursor-pointer"
                                     :style="notif.is_read ? 'opacity: 0.7' : 'font-weight: 500'"
                                     @click="markRead(notif)">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-800" x-text="notif.title"></span>
                                        <template x-if="!notif.is_read">
                                            <span class="w-1.5 h-1.5 bg-[#0D9F7A] rounded-full"></span>
                                        </template>
                                    </div>
                                    <span class="text-[11px] text-gray-500" x-text="notif.message"></span>
                                    <span class="text-[9px] text-gray-400" x-text="formatDate(notif.created_at)"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown Trigger -->
                <div class="relative">
                    <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="flex items-center gap-3 focus:outline-none text-left">
                        <!-- User Name & Class (Desktop Only) -->
                        <div class="hidden sm:flex flex-col leading-tight">
                            <span class="text-white text-xs font-medium">{{ Auth::user()->name }}</span>
                            <span class="text-[#9ca3af] text-[10px]">{{ Auth::user()->kelas ?? 'Umum' }}</span>
                        </div>
                        <!-- Avatar Inisial -->
                        <div class="w-[34px] h-[34px] bg-[#0D9F7A] rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm transition-transform hover:scale-105">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-gray-100 shadow-xl z-50 py-1"
                         style="display: none;">
                        <a href="{{ route('user.profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-decoration-none">
                            <i class="ti ti-user text-gray-400"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('user.history') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-decoration-none">
                            <i class="ti ti-history text-gray-400"></i>
                            <span>Riwayat</span>
                        </a>
                        <hr class="border-gray-100 my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left border-none bg-transparent cursor-pointer">
                                <i class="ti ti-logout"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </nav>

        <!-- MOBILE SIDEBAR (SLIDE-IN DRAWERS) -->
        <!-- Backdrop -->
        <div x-show="mobileSidebarOpen" 
             x-transition:opacity
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-50 md:hidden"
             style="display: none;"></div>

        <!-- Sidebar Panel -->
        <div x-show="mobileSidebarOpen"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 w-64 h-full bg-[#0A1628] z-50 shadow-2xl md:hidden flex flex-col justify-between py-6 px-4"
             style="display: none;">
            
            <div>
                <!-- Header Sidebar -->
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/5">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 text-decoration-none">
                        <div class="w-8 h-8 bg-[#0D9F7A] rounded-lg flex items-center justify-center">
                            <i class="ti ti-device-laptop text-white text-lg"></i>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span class="text-white font-medium text-[15px]">LendLaptop</span>
                            <span class="text-[#9FE1CB] text-xs font-semibold">UNIBI</span>
                        </div>
                    </a>
                    <button @click="mobileSidebarOpen = false" class="text-gray-400 hover:text-white">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('user.dashboard') }}" @click="mobileSidebarOpen = false"
                       class="flex items-center gap-3 text-sm px-4 py-2.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.dashboard') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/5 hover:text-white' }}">
                        <i class="ti ti-layout-dashboard text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('user.laptops.index') }}" @click="mobileSidebarOpen = false"
                       class="flex items-center gap-3 text-sm px-4 py-2.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.laptops.*') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/5 hover:text-white' }}">
                        <i class="ti ti-device-laptop text-lg"></i>
                        <span>Pinjam Laptop</span>
                    </a>

                    <a href="{{ route('user.borrowings.index') }}" @click="mobileSidebarOpen = false"
                       class="flex items-center gap-3 text-sm px-4 py-2.5 rounded-lg transition-all text-decoration-none {{ request()->routeIs('user.borrowings.*') ? 'bg-[#0D9F7A] text-white' : 'text-[#9ca3af] hover:bg-white/5 hover:text-white' }}">
                        <i class="ti ti-clipboard-list text-lg"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                </div>
            </div>

            <!-- Footer Sidebar Info -->
            <div class="border-t border-white/5 pt-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-9 h-9 bg-[#0D9F7A] rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-white text-xs font-medium">{{ Auth::user()->name }}</span>
                        <span class="text-[#9ca3af] text-[10px]">{{ Auth::user()->kelas ?? 'Umum' }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- CONTENT AREA -->
        <main class="pt-24 min-h-screen bg-gray-50 px-6 py-6">
            @if(session('success'))
                <div style="background-color: rgba(13,159,122,0.06); border: 1px solid rgba(13,159,122,0.15); border-radius: 8px; padding: 12px 16px; color: #0D9F7A; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;" class="max-w-7xl mx-auto">
                    <i class="ti ti-circle-check" style="font-size: 16px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-[#0A1628] text-center py-4 border-t border-white/5">
            <span class="text-gray-500 text-xs">© 2026 UNIBI · LendLaptop</span>
        </footer>
    </div>

    {{-- Script Notifikasi --}}
    <script>
        function notificationDropdown() {
            return {
                open: false,
                unreadCount: {{ auth()->user() ? auth()->user()->unreadNotifications()->count() : 0 }},
                notifications: [],
                fetchNotifications() {
                    fetch('{{ route("notifications.index") }}')
                        .then(res => res.json())
                        .then(data => {
                            this.notifications = data;
                        });
                },
                markRead(notif) {
                    if (notif.is_read) {
                        if (notif.link) {
                            window.location.href = notif.link;
                        }
                        return;
                    }
                    fetch(`/notifications/${notif.id}/read`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            notif.is_read = true;
                            this.unreadCount = Math.max(0, this.unreadCount - 1);
                            if (notif.link) {
                                window.location.href = notif.link;
                            }
                        }
                    });
                },
                markAllRead() {
                    fetch('/notifications/read-all', {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.notifications.forEach(n => n.is_read = true);
                            this.unreadCount = 0;
                        }
                    });
                },
                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>
</body>
</html>
