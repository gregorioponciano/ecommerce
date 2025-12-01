@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ asset($produto->imagem ?: 'storage/image/lanche.jpg') }}" 
             class="img-fluid rounded" alt="{{ $produto->nome }}">
    </div>
    <div class="col-md-6">
        <h1>{{ $produto->nome }}</h1>
        <p class="text-muted">Categoria: {{ $produto->categoria->nome }}</p>
        <p>{{ $produto->descricao }}</p>
        
        @if($produto->ingredientes->count() > 0)
            <h5>Ingredientes:</h5>
            <ul>
                @foreach($produto->ingredientes as $ingrediente)
                    <li>{{ $ingrediente->nome }}</li>
                @endforeach
            </ul>
        @endif

        @if($produto->adicionais->count() > 0)
            <h5>Adicionais:</h5>
            @foreach($produto->adicionais as $adicional)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           id="adicional{{ $adicional->id }}" 
                           data-preco="{{ $adicional->preco }}">
                    <label class="form-check-label" for="adicional{{ $adicional->id }}">
                        {{ $adicional->nome }} + R$ {{ number_format($adicional->preco, 2, ',', '.') }}
                    </label>
                </div>
            @endforeach
        @endif

        <div class="mt-4">
            <h3 class="text-primary" id="preco-total">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h3>
            <p class="text-muted">Estoque: {{ $produto->estoque }}</p>
            
            <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <input type="number" name="quantidade" value="1" min="1" 
                               max="{{ $produto->estoque }}" class="form-control" required>
                    </div>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const precoBase = {{ $produto->preco }};
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const precoTotal = document.getElementById('preco-total');
    
    function atualizarPreco() {
        let total = precoBase;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.dataset.preco);
            }
        });
        precoTotal.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarPreco);
    });
});
</script>
@endsection