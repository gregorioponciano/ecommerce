@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Editar Endereço</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('enderecos.update', $endereco->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="rua" class="form-label">Rua</label>
                                <input type="text" class="form-control @error('rua') is-invalid @enderror" 
                                       id="rua" name="rua" value="{{ old('rua', $endereco->rua) }}" required>
                                @error('rua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                       id="numero" name="numero" value="{{ old('numero', $endereco->numero) }}" required>
                                @error('numero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                               id="bairro" name="bairro" value="{{ old('bairro', $endereco->bairro) }}" required>
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                       id="cidade" name="cidade" value="{{ old('cidade', $endereco->cidade) }}" required>
                                @error('cidade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control @error('estado') is-invalid @enderror" 
                                       id="estado" name="estado" value="{{ old('estado', $endereco->estado) }}" required>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                       id="cep" name="cep" value="{{ old('cep', $endereco->cep) }}" required>
                                @error('cep')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Atualizar Endereço</button>
                        <a href="{{ route('enderecos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection