<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaResource\Pages;
use App\Models\Categoria;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput; 
use Filament\Tables\Columns\TextColumn; 
use Filament\Tables\Actions; 

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;

    // Ícone que aparece na barra lateral
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Gestão';
    // Rótulo que aparece na barra lateral (Opcional, mas útil para o plural)
    protected static ?string $navigationLabel = 'Categorias';
    protected static ?string $modelLabel = 'Categoria';
    protected static ?string $pluralModelLabel = 'Categorias';

    // Define o formulário de criação/edição
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome da Categoria')
                    ->placeholder('Ex: Eletrônicos, Livros, Vestuário...')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    // Define a tabela de listagem
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Coluna para o ID
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                // Coluna para o Nome
                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                
                // Coluna para a data de criação
                TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime('d/m/Y H:i') // Formato de data e hora
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Sem filtros por enquanto
            ])
            ->actions([
                // Ações por registro
                Actions\EditAction::make(),
                Actions\DeleteAction::make(), // Adicionei DeleteAction para ação individual
            ])
            ->bulkActions([
                // Ações em massa
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    } // Fim do método table() - A DUPLICAÇÃO FOI REMOVIDA AQUI!

    public static function getRelations(): array
    {
        return [
            // Se você tivesse um ProductRelationManager, ele viria aqui
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit' => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}