<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machere Driving School - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --burgundy: #800020;
            --burgundy-dark: #600018;
            --burgundy-light: #a0002a;
            --ice-blue: #E8F4F8;
            --ice-blue-dark: #B8D4E8;
            --ice-blue-accent: #5B9EC9;
        }
        .bg-burgundy { background-color: #800020; }
        .bg-burgundy-dark { background-color: #600018; }
        .hover\:bg-burgundy-dark:hover { background-color: #600018; }
        .text-burgundy { color: #800020; }
        .border-burgundy { border-color: #800020; }
        .bg-ice-blue { background-color: #E8F4F8; }
        .bg-ice-blue-dark { background-color: #B8D4E8; }
        .text-ice-blue { color: #5B9EC9; }
        .sidebar-link:hover { background-color: #600018; }
        .active-link { background-color: #600018; border-left: 4px solid #B8D4E8; }
    </style>
</head>
<body class="font-sans" style="background-color: #E8F4F8;">

    <!-- Top Navbar -->
    <nav class="bg-burgundy text-white px-6 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🚗</span>
            <div>
                <p class="text-lg font-bold leading-none">Machere Driving School</p>
                <p class="text-xs" style="color: #B8D4E8;">Management System</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-xs" style="color: #B8D4E8;">Head Office Admin</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="text-sm font-semibold px-4 py-2 rounded border border-white hover:bg-white transition"
                    style="color: white;"
                    onmouseover="this.style.color='#800020'"
                    onmouseout="this.style.color='white'">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 text-white shadow-xl" style="background-color: #600018;">
            <div class="p-4 border-b" style="border-color: #800020;">
                <p class="text-xs uppercase tracking-widest" style="color: #B8D4E8;">Navigation</p>
            </div>
            <ul class="py-4">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center gap-3 px-6 py-3 text-sm hover:bg-burgundy transition sidebar-link">
                        📊 <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.branches.index') }}" 
                        class="flex items-center gap-3 px-6 py-3 text-sm hover:bg-burgundy transition sidebar-link">
                        🏢 <span>Branches</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" 
                        class="flex items-center gap-3 px-6 py-3 text-sm hover:bg-burgundy transition sidebar-link">
                        👥 <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.license-categories.index') }}" 
                        class="flex items-center gap-3 px-6 py-3 text-sm hover:bg-burgundy transition sidebar-link">
                        📋 <span>License Categories</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded border text-sm font-medium"
                    style="background-color: #d1fae5; border-color: #6ee7b7; color: #065f46;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded border text-sm font-medium"
                    style="background-color: #fee2e2; border-color: #fca5a5; color: #991b1b;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>