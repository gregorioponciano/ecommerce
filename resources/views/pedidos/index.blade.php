@extends('layouts.app')
@section('title', 'Meus Pedidos - Lanchonete Delícia')
@section('content')
<h1 class="mb-4">Meus Pedidos</h1>

@if($pedidos->count() > 0)
    <div class="row">
        @foreach($pedidos as $pedido)
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pedido #{{ $pedido->id }}</h5>
                        <span class="badge 
                            @if($pedido->status == 'entregue') bg-success
                            @elseif($pedido->status == 'preparando') bg-warning
                            @elseif($pedido->status == 'confirmado') bg-info
                            @elseif($pedido->status == 'cancelado') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($pedido->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Data:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Total:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
                                <p><strong>Pagamento:</strong> {{ ucfirst($pedido->metodo_pagamento) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Endereço de entrega:</strong></p>
                                <p class="text-muted">{{ $pedido->endereco_entrega }}</p>
                            </div>
                        </div>
                        
                        <h6>Itens do pedido:</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($pedido->itens as $item)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $item->produto->nome }} x{{ $item->quantidade }}</span>
                                    <span>R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        @if($pedido->observacoes)
                            <div class="mt-3">
                                <strong>Observações:</strong>
                                <p class="text-muted">{{ $pedido->observacoes }}</p>
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-outline-primary btn-sm">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
        <h3>Nenhum pedido realizado</h3>
        <p class="text-muted">Faça seu primeiro pedido e acompanhe o status aqui.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Fazer Pedido</a>
    </div>
@endif
@endsection