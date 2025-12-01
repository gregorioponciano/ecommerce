<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'telefone',
        'is_admin',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function carrinho()
    {
        return $this->hasMany(Carrinho::class);
    }
}