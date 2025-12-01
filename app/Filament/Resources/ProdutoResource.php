<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoResource\Pages;
use App\Models\Produto;
use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Gestão';

    protected static ?string $navigationLabel = 'Produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Produto')
                    ->schema([
                        Forms\Components\Select::make('categoria_id')
                            ->label('Categoria')
                            ->options(Categoria::all()->pluck('nome', 'id'))
                            ->searchable()
                            ->required()
                            ->native(false),
                        
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome do Produto')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        
                        Forms\Components\Textarea::make('descricao')
                            ->label('Descrição')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->required()
                            ->prefix('R$')
                            ->minValue(0)
                            ->step(0.01),
                        
                        Forms\Components\TextInput::make('estoque')
                            ->label('Estoque')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Imagem do Produto')
                    ->schema([
                        Forms\Components\FileUpload::make('imagem')
                            ->label('Imagem do Produto')
                            ->image()
                            ->directory('produtos')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600')
                            ->imagePreviewHeight('200')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('Formatos: JPG, PNG, WEBP. Tamanho máximo: 5MB. Dimensões recomendadas: 800x600px')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('Imagem')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->circular(),
                
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('categoria.nome')
                    ->label('Categoria')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('estoque')
                    ->label('Estoque')
                    ->sortable()
                    ->color(fn ($record) => $record->estoque > 10 ? 'success' : ($record->estoque > 0 ? 'warning' : 'danger')),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->relationship('categoria', 'nome')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('em_estoque')
                    ->label('Em Estoque')
                    ->query(fn ($query) => $query->where('estoque', '>', 0)),
                
                Tables\Filters\Filter::make('sem_estoque')
                    ->label('Sem Estoque')
                    ->query(fn ($query) => $query->where('estoque', '<=', 0)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}