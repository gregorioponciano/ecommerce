@extends('layouts.app')
@section('title', 'Carrinho - Lanchonete Delícia')
@section('content')
<h1 class="mb-4">Meu Carrinho</h1>

@if($itens->count() > 0)
    <div class="row">
        <div class="col-md-8">
            @foreach($itens as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ asset($item->produto->imagem ?: 'storage/image/lanche.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $item->produto->nome }}">
                            </div>
                            <div class="col-md-6">
                                <h5>{{ $item->produto->nome }}</h5>
                                <p class="text-muted">{{ $item->produto->descricao }}</p>
                                <p class="h5 text-primary">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</p>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('carrinho.atualizar', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantidade" value="{{ $item->quantidade }}" 
                                           min="1" max="{{ $item->produto->estoque }}" class="form-control">
                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-1 w-100">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('carrinho.remover', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <p class="mt-2 fw-bold">Subtotal: R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumo do Pedido</h5>
                    <p class="h4 text-primary">Total: R$ {{ number_format($total, 2, ',', '.') }}</p>
                    
                    <a href="{{ route('pedidos.checkout') }}" class="btn btn-success btn-lg w-100 mt-3">
                        <i class="fas fa-credit-card"></i> Finalizar Pedido
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
        <h3>Seu carrinho está vazio</h3>
        <p class="text-muted">Adicione alguns produtos deliciosos!</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Continuar Comprando</a>
    </div>
@endif
@endsection