<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete Delícia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .card { transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .categoria-section { margin-bottom: 3rem; }
        .produto-img { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-hamburger"></i> Lanchonete Delícia
            </a>
            
            <div class="navbar-nav ms-auto">
                @auth
                    <a class="nav-link" href="{{ route('carrinho.index') }}">
                        <i class="fas fa-shopping-cart"></i> Carrinho
                        @php
                            $carrinhoCount = Auth::user()->carrinho()->count();
                        @endphp
                        @if($carrinhoCount > 0)
                            <span class="badge bg-danger">{{ $carrinhoCount }}</span>
                        @endif
                    </a>
                    <a class="nav-link" href="{{ route('pedidos.index') }}">Meus Pedidos</a>
                    <a class="nav-link" href="{{ route('enderecos.index') }}">Endereços</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link border-0">Sair</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>