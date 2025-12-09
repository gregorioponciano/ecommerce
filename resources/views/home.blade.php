@extends('layouts.app')
@section('title', 'Home - Lanchonete Delícia')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <form action="{{ route('buscar') }}" method="GET" class="d-flex">
            <input type="text" name="q" class="form-control me-2" placeholder="Buscar produtos..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

@if($categorias->count() > 0)
<div class="categorias-tabs">
    <!-- Navegação por abas -->
    <ul class="nav nav-tabs mb-4" id="categoriasTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="todas-tab" data-bs-toggle="tab" data-bs-target="#todas" type="button" role="tab" aria-controls="todas" aria-selected="true">
                TODAS AS CATEGORIAS
            </button>
        </li>
        @foreach($categorias as $index => $categoria)
            @if($categoria->produtos->count() > 0)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="categoria-{{ $categoria->id }}-tab" data-bs-toggle="tab" data-bs-target="#categoria-{{ $categoria->id }}" type="button" role="tab" aria-controls="categoria-{{ $categoria->id }}" aria-selected="false">
                    {{ strtoupper($categoria->nome) }}
                </button>
            </li>
            @endif
        @endforeach
    </ul>

    <!-- Conteúdo das abas -->
    <div class="tab-content" id="categoriasTabContent">
        <!-- Tab TODAS AS CATEGORIAS -->
        <div class="tab-pane fade show active" id="todas" role="tabpanel" aria-labelledby="todas-tab">
            <div class="row">
                @php
                    $allProducts = collect();
                    foreach($categorias as $categoria) {
                        if($categoria->produtos->count() > 0) {
                            $allProducts = $allProducts->merge($categoria->produtos);
                            
                        }
                    }
                    
                @endphp
                
                @if($allProducts->count() > 0)
                    @foreach($allProducts as $produto)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset($produto->imagem ?: 'storage/image/lanche.jpg') }}" alt="{{ $produto->nome }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $produto->nome }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($produto->descricao, 100) }}</p>
                                    <div class="mt-auto">
                                        <p class="h5 text-primary">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                                        <p class="text-muted">Estoque: {{ $produto->estoque }}</p>
                                        <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group mb-2">
                                                <input type="number" name="quantidade" value="1" min="1" max="{{ $produto->estoque }}" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-cart-plus"></i> Adicionar
                                            </button>
                                        </form>
                                        <a href="{{ route('produto', $produto->id) }}" class="btn btn-outline-primary w-100 mt-2">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-center text-muted">Nenhum produto encontrado.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabs individuais para cada categoria -->
        @foreach($categorias as $categoria)
            @if($categoria->produtos->count() > 0)
            <div class="tab-pane fade" id="categoria-{{ $categoria->id }}" role="tabpanel" aria-labelledby="categoria-{{ $categoria->id }}-tab">
                <div class="row">
                    @foreach($categoria->produtos as $produto)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset($produto->imagem ?: 'storage/image/lanche.jpg') }}" 
                                     class="card-img-top produto-img" alt="{{ $produto->nome }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $produto->nome }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($produto->descricao, 100) }}</p>
                                    <div class="mt-auto">
                                        <p class="h5 text-primary">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                                        <p class="text-muted">Estoque: {{ $produto->estoque }}</p>
                                        <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group mb-2">
                                                <input type="number" name="quantidade" value="1" min="1" max="{{ $produto->estoque }}" 
                                                       class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-cart-plus"></i> Adicionar
                                            </button>
                                        </form>
                                        <a href="{{ route('produto', $produto->id) }}" class="btn btn-outline-primary w-100 mt-2">
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@else
<div class="alert alert-info">
    Nenhuma categoria com produtos disponível.
</div>
@endif
@endsection

@push('styles')
<style>
.nav-tabs .nav-link {
    font-weight: bold;
    color: #6c757d;
    border: none;
    padding: 12px 20px;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom: 3px solid #007bff;
    background-color: transparent;
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6;
}

.tab-content {
    padding: 20px 0;
}
</style>
@endpush