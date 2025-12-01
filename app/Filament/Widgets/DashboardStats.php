<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Pedido;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Notifications\Notification;

class DashboardStats extends BaseWidget
{
    // 🔁 Atualiza automaticamente a cada 10 segundos
    protected static ?string $pollingInterval = '10s';

    // Armazena o último ID de pedido verificado
    protected static ?int $ultimoPedidoId = null;

    protected function getStats(): array
    {
        $totalProdutos = Produto::count();
        $totalCategorias = Categoria::count();
        $estoqueBaixo = Produto::where('estoque', '<=', 5)->count();
        $totalUsuarios = User::count();
        $ultimoPedido = Pedido::latest()->first();

        // 🔔 Verifica se há novo pedido
        if ($ultimoPedido && self::$ultimoPedidoId !== null && $ultimoPedido->id !== self::$ultimoPedidoId) {
            Notification::make()
                ->title('🛒 Novo Pedido Recebido!')
                ->body('Um novo pedido foi feito por ' . ($ultimoPedido->user->name ?? 'Cliente') . '.')
                ->color('success')
                ->icon('heroicon-o-bell-alert')
                ->send();
        }

        // Atualiza o ID armazenado
        self::$ultimoPedidoId = $ultimoPedido?->id ?? null;

        return [
            Stat::make('Total de Produtos', $totalProdutos)
                ->description('Produtos cadastrados')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('success')
                ->chart($this->getProdutosChartData()),

            Stat::make('Categorias', $totalCategorias)
                ->description('Categorias ativas')
                ->descriptionIcon('heroicon-o-tag')
                ->color('primary'),

            Stat::make('Estoque Baixo', $estoqueBaixo)
                ->description('Necessita atenção')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($estoqueBaixo > 0 ? 'danger' : 'gray'),

            Stat::make('Usuários', $totalUsuarios)
                ->description('Usuários cadastrados')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),
        ];
    }

    private function getProdutosChartData(): array
    {
        // Exemplo de gráfico (pode ser substituído por dados reais)
        return [2, 5, 8, 12, 15, 18, 20];
    }
}
