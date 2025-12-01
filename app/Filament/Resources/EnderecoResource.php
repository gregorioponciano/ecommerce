<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnderecoResource\Pages;
use App\Filament\Resources\EnderecoResource\RelationManagers;
use App\Models\Endereco;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnderecoResource extends Resource
{
    protected static ?string $model = Endereco::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Administração';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('numero')
                    ->maxLength(10)
                    ->default(null),
                Forms\Components\TextInput::make('bairro')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('cidade')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estado')
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('cep')
                    ->maxLength(20)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bairro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cep')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListEnderecos::route('/'),
            'create' => Pages\CreateEndereco::route('/create'),
            'edit' => Pages\EditEndereco::route('/{record}/edit'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
