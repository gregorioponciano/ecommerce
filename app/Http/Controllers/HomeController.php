<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['produtos' => function($query) {
            $query->where('estoque', '>', 0);
        }])->get();

        return view('home', compact('categorias'));
    }

    public function produto($id)
    {
        $produto = Produto::with(['categoria', 'ingredientes', 'adicionais'])->findOrFail($id);
        return view('produto', compact('produto'));
    }

    public function buscar(Request $request)
    {
        $termo = $request->get('q');
        $produtos = Produto::where('nome', 'LIKE', "%{$termo}%")
                          ->orWhere('descricao', 'LIKE', "%{$termo}%")
                          ->where('estoque', '>', 0)
                          ->get();

        return view('busca', compact('produtos', 'termo'));
    }
}