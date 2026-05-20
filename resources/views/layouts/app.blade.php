{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Logotipo Oficial') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #070707;
            font-family: 'Inter', 'Sora', system-ui, -apple-system, sans-serif;
            height: 100%;
            overflow: hidden;
        }
        
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #eab308;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #facc15;
        }
        
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeUp {
            animation: fadeUp 0.5s ease-out forwards;
        }
        
        /* Estilo para o sidebar */
        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #eab308;
            transition: height 0.2s ease;
            border-radius: 0 2px 2px 0;
        }
        
        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            height: 70%;
        }
        
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(234,179,8,0.1) 0%, transparent 100%);
            color: #eab308 !important;
        }
        
        .logo-marca {
            background: linear-gradient(135deg, #eab308 0%, #ca9a00 100%);
            box-shadow: 0 20px 35px -12px rgba(234,179,8,0.3);
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <div class="h-full flex">
        <!-- Sidebar - largura fixa -->
        @include('layouts.sidebar')
        
        <!-- Conteúdo principal - ocupa o resto do espaço -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('layouts.header')
            
            <!-- Conteúdo da página com scroll -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="max-w-full">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>