@extends('layouts.app')
@section('title', 'Detalhes do Pedido - Lanchonete Delícia')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Pedido #{{ $pedido->id }}</h4>
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
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informações do Pedido</h5>
                        <p><strong>Data:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Total:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
                        <p><strong>Método de Pagamento:</strong> {{ ucfirst($pedido->metodo_pagamento) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Endereço de Entrega</h5>
                        <p class="text-muted">{{ $pedido->endereco_entrega }}</p>
                    </div>
                </div>

                <h5>Itens do Pedido</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unitário</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->itens as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->produto->imagem ?: 'storage/image/lanche.jpg') }}" 
                                                 class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $item->produto->nome }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($item->produto->descricao, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>R$ {{ number_format($pedido->total, 2, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($pedido->observacoes)
                    <div class="mt-4">
                        <h5>Observações</h5>
                        <p class="text-muted">{{ $pedido->observacoes }}</p>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar para Meus Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection