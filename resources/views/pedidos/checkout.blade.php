@extends('layouts.app')

@section('content')
<h1 class="mb-4">Finalizar Pedido</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Itens do Pedido</h5>
            </div>
            <div class="card-body">
                @foreach($itens as $item)
                    <div class="row mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ asset($item->produto->imagem ?: 'storage/image/lanche.jpg') }}" 
                                 class="img-fluid rounded" alt="{{ $item->produto->nome }}">
                        </div>
                        <div class="col-md-6">
                            <h6>{{ $item->produto->nome }}</h6>
                            <p class="text-muted mb-0">Quantidade: {{ $item->quantidade }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="fw-bold">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-3">
                    <div class="col-12 text-end">
                        <h4>Total: R$ {{ number_format($total, 2, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Endereço de Entrega</h5>
                </div>
                <div class="card-body">
                    @if($enderecos->count() > 0)
                        @foreach($enderecos as $endereco)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="endereco_id" 
                                       value="{{ $endereco->id }}" id="endereco{{ $endereco->id }}" 
                                       {{ $loop->first ? 'checked' : '' }}> 
                                <label class="form-check-label" for="endereco{{ $endereco->id }}">
                                    <strong>{{ $endereco->endereco_completo }}</strong>
                                </label><hr>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Nenhum endereço cadastrado.</p>
                        <a href="{{ route('enderecos.create') }}" class="btn btn-outline-primary btn-sm">
                            Cadastrar Endereço
                        </a>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5>Método de Pagamento</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pagamento" value="pix" id="pix" checked>
                        <label class="form-check-label" for="pix">
                            <i class="fas fa-qrcode"></i> PIX
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pagamento" value="cartao" id="cartao">
                        <label class="form-check-label" for="cartao">
                            <i class="fas fa-credit-card"></i> Cartão
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo_pagamento" value="dinheiro" id="dinheiro">
                        <label class="form-check-label" for="dinheiro">
                            <i class="fas fa-money-bill"></i> Dinheiro
                        </label>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5>Observações</h5>
                </div>
                <div class="card-body">
                    <textarea name="observacoes" class="form-control" rows="3" 
                              placeholder="Alguma observação para o pedido?"></textarea>
                </div>
            </div>

            @if($enderecos->count() > 0)
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-check"></i> Confirmar Pedido
                </button>
            @else
                <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                    Cadastre um endereço primeiro
                </button>
            @endif
        </form>
    </div>
</div>
@endsection