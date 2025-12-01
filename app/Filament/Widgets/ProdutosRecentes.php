<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProdutosRecentes extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Produtos Recentes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produto::query()
                    ->with('categoria')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
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
                    ->sortable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('estoque')
                    ->label('Estoque')
                    ->sortable()
                    ->color(fn ($state): string => match (true) {
                        $state == 0 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state): string => $state == 0 ? 'ESGOTADO' : $state . ' unidades'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Produto $record): string => route('filament.admin.resources.produtos.edit', $record)),
            ])
            ->emptyStateHeading('Nenhum produto cadastrado')
            ->emptyStateDescription('Cadastre seu primeiro produto para começar.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}