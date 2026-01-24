<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - ZENIRO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-secondary min-h-screen">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Overlay -->
        <div id="sidebarOverlay" 
             class="fixed inset-0 bg-black/50 z-40 md:hidden hidden backdrop-blur-sm transition-opacity duration-300"
             onclick="closeSidebar()">
        </div>

        <!-- Sidebar -->
        <aside id="sidebar" 
               class="w-60 bg-primary-primaryBlue shrink-0 fixed md:static inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="h-full flex flex-col">

                <!-- Logo -->
                <div class="px-6 py-8 border-b border-accent-blue/30">
                    <img src="{{ asset('img/logo/zeniroWhiteBlue.png') }}" alt="ZENIRO" class="w-4/6 object-contain">
                    <p class="pt-2 text-sm font-sans font-semibold text-accent-bluesoft">Admin Panel</p>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-sans font-bold">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.products.*') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="font-sans font-bold">Products</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-sans font-bold">Orders</span>
                    </a>

                    <a href="{{ route('admin.messages.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.messages.*') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-sans font-bold">Messages</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-sans font-bold">Users</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="px-4 py-6 border-t border-accent-blue/30">
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.profile') ? 'bg-accent-blue text-white' : 'text-accent-bluesoft hover:bg-accent-blue/20 hover:text-white' }}">
                        <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center">
                            <span class="font-heading font-bold text-primary-primaryBlue">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-sans font-bold text-sm">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="font-sans text-xs">{{ auth()->user()->email ?? 'admin@zeniro.com' }}</p>
                        </div>
                    </a>
                </div>

            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Bar -->
            <header class="bg-white border-b border-gray/20 px-4 md:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Hamburger Menu (Mobile Only) -->
                        <button onclick="toggleSidebar()" 
                                class="md:hidden p-2 text-primary-primaryBlue hover:bg-secondary rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <h2 class="text-xl md:text-2xl font-heading font-bold text-primary-primaryBlue">
                            @yield('page-title', 'Dashboard')
                        </h2>
                    </div>

                    <div class="flex items-center gap-2 md:gap-4">
                        <!-- Go to Website Button -->
                        <a href="{{ url('/') }}" target="_blank"
                            class="hidden sm:inline-flex px-4 md:px-6 py-2 bg-accent-blue text-white rounded-lg font-bold hover:bg-accent-blue/90 transition text-xs md:text-sm">
                            Go to Website
                        </a>

                        <!-- Go to Website Icon (Mobile) -->
                        <a href="{{ url('/') }}" target="_blank"
                            class="sm:hidden p-2 bg-accent-blue text-white rounded-lg hover:bg-accent-blue/90 transition"
                            title="Go to Website">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </a>

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-3 md:px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-sans font-bold text-xs md:text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <p class="text-sm text-green-700 font-sans font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <p class="text-sm text-red-700 font-sans font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="font-sans">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>

    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            
            // Prevent body scroll when sidebar is open
            if (!sidebar.classList.contains('-translate-x-full')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close sidebar when clicking on nav links (mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('#sidebar a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });

        // Close sidebar with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
    </script>

</body>

</html>