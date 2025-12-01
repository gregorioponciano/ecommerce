<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nome',
        'descricao',
        'preco',
        'imagem',
        'estoque'
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
        ];
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function adicionais()
    {
        return $this->hasMany(Adicional::class);
    }

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class);
    }
}