<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Models\Pedido;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Vendas';
    protected static ?string $navigationLabel = 'Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Cliente')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('total')
                    ->label('Total (R$)')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status do Pedido')
                    ->options([
                        'pendente' => 'Pendente',
                        'confirmado' => 'Confirmado',
                        'preparando' => 'Preparando',
                        'entregue' => 'Entregue',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('pendente')
                    ->required(),

                Forms\Components\Select::make('metodo_pagamento')
                    ->label('Método de Pagamento')
                    ->options([
                        'pix' => 'PIX',
                        'cartao' => 'Cartão',
                        'dinheiro' => 'Dinheiro',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('endereco_entrega')
                    ->label('Endereço de Entrega')
                    ->required()
                    ->rows(3),

                Forms\Components\Textarea::make('observacoes')
                    ->label('Observações')
                    ->rows(2)
                    ->maxLength(500)
                    ->placeholder('Ex: Sem cebola, entregar na portaria...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'pendente',
                        'success' => 'confirmado',
                        'warning' => 'preparando',
                        'info' => 'entregue',
                        'danger' => 'cancelado',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('metodo_pagamento')
                    ->label('Pagamento')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pendente' => 'Pendente',
                        'confirmado' => 'Confirmado',
                        'preparando' => 'Preparando',
                        'entregue' => 'Entregue',
                        'cancelado' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Aqui você pode adicionar RelationManagers, ex: Itens do pedido
            // RelationManagers\PedidoItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPedidos::route('/'),
            'create' => Pages\CreatePedido::route('/create'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
            'view' => Pages\ViewPedido::route('/{record}'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
}
        