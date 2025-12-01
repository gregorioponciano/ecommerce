<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProdutosEstoqueBaixo extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Produtos com Estoque Baixo';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produto::query()
                    ->with('categoria')
                    ->where('estoque', '<=', 5)
                    ->orderBy('estoque', 'asc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('')
                    ->disk('public')
                    ->width(40)
                    ->height(40)
                    ->circular(),

                Tables\Columns\TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn (Produto $record): string => $record->categoria?->nome ?? 'Sem categoria'),

                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estoque')
                    ->label('Estoque')
                    ->sortable()
                    ->color(fn ($state): string => $state == 0 ? 'danger' : 'warning')
                    ->formatStateUsing(fn ($state): string => $state == 0 ? 'ESGOTADO' : $state . ' unidades')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Última atualização')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Repor Estoque')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(fn (Produto $record): string => route('filament.admin.resources.produtos.edit', $record)),
            ])
            ->emptyStateHeading('Nenhum produto com estoque baixo')
            ->emptyStateDescription('Todos os produtos estão com estoque adequado.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}