@extends('layouts.app')
@section('title', 'Buscar - Lanchonete Delícia')
@section('content')
<h1 class="mb-4">Resultados da busca: "{{ $termo }}"</h1>

@if($produtos->count() > 0)
    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($produto->imagem ?: 'storage/image/lanche.jpg') }}" 
                         class="card-img-top produto-img" alt="{{ $produto->nome }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $produto->nome }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($produto->descricao, 100) }}</p>
                        <div class="mt-auto">
                            <p class="h5 text-primary">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="number" name="quantidade" value="1" min="1" 
                                           max="{{ $produto->estoque }}" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-cart-plus"></i> Adicionar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h3>Nenhum produto encontrado</h3>
        <p class="text-muted">Tente buscar com outros termos.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Voltar para a loja</a>
    </div>
@endif
sxr
@endsection