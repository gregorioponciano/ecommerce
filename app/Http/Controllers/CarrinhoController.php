<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function index()
    {
        $itens = Auth::user()->carrinho()->with('produto')->get();
        $total = $itens->sum(function ($item) {
            return $item->produto->preco * $item->quantidade;
        });

        return view('carrinho', compact('itens', 'total'));
    }

    public function adicionar(Request $request, $produtoId)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);

        $produto = Produto::findOrFail($produtoId);

        if ($produto->estoque < $request->quantidade) {
            return back()->with('error', 'Quantidade indisponível em estoque.');
        }

        $itemExistente = Carrinho::where('user_id', Auth::id())
                                ->where('produto_id', $produtoId)
                                ->first();

        if ($itemExistente) {
            $itemExistente->quantidade += $request->quantidade;
            $itemExistente->save();
        } else {
            Carrinho::create([
                'user_id' => Auth::id(),
                'produto_id' => $produtoId,
                'quantidade' => $request->quantidade
            ]);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);

        $item = Carrinho::where('user_id', Auth::id())->findOrFail($id);
        
        if ($item->produto->estoque < $request->quantidade) {
            return back()->with('error', 'Quantidade indisponível em estoque.');
        }

        $item->update(['quantidade' => $request->quantidade]);

        return back()->with('success', 'Carrinho atualizado!');
    }

    public function remover($id)
    {
        $item = Carrinho::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Produto removido do carrinho!');
    }
}