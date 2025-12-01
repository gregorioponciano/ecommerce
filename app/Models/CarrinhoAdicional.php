<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoAdicional extends Model
{
    use HasFactory;

    protected $table = 'carrinho_adicionais';

    protected $fillable = [
        'carrinho_id',
        'adicional_id'
    ];

    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class);
    }

    public function adicional()
    {
        return $this->belongsTo(Adicional::class);
    }
}