<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoItemResource\Pages;
use App\Filament\Resources\PedidoItemResource\RelationManagers;
use App\Models\PedidoItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PedidoItemResource extends Resource
{
    protected static ?string $model = PedidoItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPedidoItems::route('/'),
            'create' => Pages\CreatePedidoItem::route('/create'),
            'edit' => Pages\EditPedidoItem::route('/{record}/edit'),
        ];
    }
}
