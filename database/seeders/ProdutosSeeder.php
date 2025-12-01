<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutosSeeder extends Seeder
{
    public function run()
    {
        $produtos = [
            // Lanches (ID 1)
            ['categoria_id' => 1, 'nome' => 'X-Salada Clássico', 'descricao' => 'Hambúrguer, queijo prato, alface, tomate e maionese da casa.', 'preco' => 22.50, 'estoque' => 50],
            ['categoria_id' => 1, 'nome' => 'X-Bacon Supremo', 'descricao' => 'Hambúrguer duplo, muito bacon crocante e cheddar cremoso.', 'preco' => 28.90, 'estoque' => 45],
            ['categoria_id' => 1, 'nome' => 'Sanduíche Vegetariano', 'descricao' => 'Pão integral, queijo coalho, abobrinha e berinjela grelhadas.', 'preco' => 19.90, 'estoque' => 60],
            ['categoria_id' => 1, 'nome' => 'Cheeseburger Duplo', 'descricao' => 'Dois hambúrgueres de carne com queijo muçarela derretido.', 'preco' => 32.00, 'estoque' => 40],
            ['categoria_id' => 1, 'nome' => 'X-Tudo Monstro', 'descricao' => 'Todos os acompanhamentos: ovo, bacon, calabresa e queijo.', 'preco' => 45.00, 'estoque' => 25],
            
            // Bebidas (ID 2)
            ['categoria_id' => 2, 'nome' => 'Refrigerante Lata (Coca-Cola)', 'descricao' => 'Lata de 350ml.', 'preco' => 6.00, 'estoque' => 120],
            ['categoria_id' => 2, 'nome' => 'Refrigerante Lata (Guaraná)', 'descricao' => 'Lata de 350ml.', 'preco' => 6.00, 'estoque' => 100],
            ['categoria_id' => 2, 'nome' => 'Suco Natural de Laranja', 'descricao' => 'Copo de 300ml.', 'preco' => 8.50, 'estoque' => 80],
            
            // Porções (ID 3)
            ['categoria_id' => 3, 'nome' => 'Batata Frita Grande', 'descricao' => 'Porção de 500g de batatas rústicas com alecrim.', 'preco' => 15.00, 'estoque' => 60],
            ['categoria_id' => 3, 'nome' => 'Anéis de Cebola', 'descricao' => 'Porção de anéis de cebola empanados (300g).', 'preco' => 18.00, 'estoque' => 55],
            
            // Combos (ID 4)
            ['categoria_id' => 4, 'nome' => 'Combo Executivo', 'descricao' => '1 X-Salada Clássico + Batata Média + Refrigerante Lata.', 'preco' => 35.00, 'estoque' => 40],
            ['categoria_id' => 4, 'nome' => 'Combo Duplo Bacon', 'descricao' => '2 X-Bacon Supremo + 1 Porção de Anéis de Cebola + 2 Refrigerantes.', 'preco' => 69.90, 'estoque' => 30],
        ];

        foreach ($produtos as $produto) {
            DB::table('produtos')->insert(array_merge($produto, [
                'imagem' => 'storage/image/lanche.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}