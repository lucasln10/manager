<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Manager</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite React + Tailwind + CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <img src="/img/managericon.png" alt="Manager" class="h-8 w-8">
                        <span class="text-xl font-bold text-primary">Manager</span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ route('home.index') }}" 
                       class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Home
                    </a>
                    <a href="{{ route('funcionarios.index') }}" 
                       class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Funcionários
                    </a>
                    <a href="{{ route('departamentos.index') }}" 
                       class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Departamentos
                    </a>
                    <a href="{{ route('cargos.index') }}" 
                       class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Cargos
                    </a>
                    <a href="{{ route('tarefas.index') }}" 
                       class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Tarefas
                    </a>

                    @auth
                        <div class="flex items-center gap-4">
                            <span class="text-gray-700 font-medium hidden md:inline">Olá, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-red-400">
                                    Sair
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="/login" class="bg-primary hover:bg-primary-light text-white px-4 py-2 rounded-md text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-primary">
                                Login
                            </a>
                            <a href="/register" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-primary">
                                Registrar
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                            aria-controls="mobile-menu" 
                            aria-expanded="false">
                        <span class="sr-only">Abrir menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50">
                    Home
                </a>
                <a href="{{ route('funcionarios.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50">
                    Funcionários
                </a>
                <a href="{{ route('tarefas.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50">
                    Tarefas
                </a>
                <a href="{{ route('departamentos.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50">
                    Departamentos
                </a>
                <a href="{{ route('cargos.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50">
                    Cargos
                </a>

                @auth
                    <span class="block px-3 py-2 text-base font-medium text-gray-700">Olá, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-400">
                            Sair
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="/login" class="block px-3 py-2 rounded-md text-base font-medium text-primary hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">Login</a>
                    <a href="/register" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">Registrar</a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Compensação para navbar fixa -->
    <div class="h-16"></div>

    <!-- React Root -->
    <div id="react-root" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4"></div>

    <!-- Conteúdo específico -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">
                    &copy; {{ date('Y') }} Manager. Todos os direitos reservados.
                </p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-200">
                        Privacidade
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-200">
                        Termos
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-200">
                        Suporte
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mobile menu script -->
    <script>
        document.querySelector('[aria-controls="mobile-menu"]').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>