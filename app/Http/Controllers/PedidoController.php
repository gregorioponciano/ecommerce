<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Carrinho;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Auth::user()->pedidos()->with('itens.produto')->latest()->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function checkout()
    {
        $itens = Auth::user()->carrinho()->with('produto')->get();
        $enderecos = Auth::user()->enderecos;
        $total = $itens->sum(function ($item) {
            return $item->produto->preco * $item->quantidade;
        });

        if ($itens->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        return view('pedidos.checkout', compact('itens', 'enderecos', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'metodo_pagamento' => 'required|in:pix,cartao,dinheiro',
            'observacoes' => 'nullable|string'
        ]);

        $itensCarrinho = Auth::user()->carrinho()->with('produto')->get();

        if ($itensCarrinho->isEmpty()) {
            return back()->with('error', 'Seu carrinho está vazio.');
        }

        foreach ($itensCarrinho as $item) {
            if ($item->produto->estoque < $item->quantidade) {
                return back()->with('error', "O produto {$item->produto->nome} não tem estoque suficiente.");
            }
        }

        try {
            DB::beginTransaction();

            $endereco = Endereco::findOrFail($request->endereco_id);
            $total = $itensCarrinho->sum(function ($item) {
                return $item->produto->preco * $item->quantidade;
            });

            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pendente',
                'metodo_pagamento' => $request->metodo_pagamento,
                'endereco_entrega' => $endereco->endereco_completo,
                'observacoes' => $request->observacoes
            ]);

            foreach ($itensCarrinho as $item) {
                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $item->produto_id,
                    'quantidade' => $item->quantidade
                ]);

                // Atualizar estoque
                $item->produto->decrement('estoque', $item->quantidade);
            }

            // Limpar carrinho
            Auth::user()->carrinho()->delete();

            DB::commit();

            return redirect()->route('pedidos.index')->with('success', 'Pedido realizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao processar pedido: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pedido = Auth::user()->pedidos()->with('itens.produto')->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }
}