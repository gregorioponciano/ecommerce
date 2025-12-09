@extends('layouts.app')
@section('title', 'Meus Endereços - Lanchonete Delícia')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Meus Endereços</h1>
    <a href="{{ route('enderecos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Endereço
    </a>
</div>

@if($enderecos->count() > 0)
    <div class="row">
        @foreach($enderecos as $endereco)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Endereço {{ $loop->iteration }}</h5>
                        <p class="card-text">
                            <strong>{{ $endereco->endereco_completo }}</strong>
                        </p>
                        <div class="btn-group">
                            <a href="{{ route('enderecos.edit', $endereco->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('enderecos.destroy', $endereco->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir este endereço?')">
                                    <i class="fas fa-trash"></i> Excluir
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
        <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
        <h3>Nenhum endereço cadastrado</h3>
        <p class="text-muted">Cadastre seu primeiro endereço para receber pedidos.</p>
        <a href="{{ route('enderecos.create') }}" class="btn btn-primary">Cadastrar Endereço</a>
    </div>
@endif
@endsection