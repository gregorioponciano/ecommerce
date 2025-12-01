<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $navigationGroup = 'Administração';

    public static function form(Form $form): Form
    {
        $isAdmin = Auth::user()?->is_admin ?? false;

        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            Forms\Components\TextInput::make('cpf')
                ->label('CPF')
                ->unique(ignoreRecord: true)
                ->required(),

            Forms\Components\TextInput::make('telefone')
                ->label('Telefone')
                ->mask('(99) 99999-9999')
                ->maxLength(255),

            Forms\Components\Toggle::make('is_admin')
                ->label('Administrador?')
                ->visible($isAdmin)
                ->default(false),

            // Grupo de senha e confirmação
            Forms\Components\Fieldset::make('Alterar Senha')
                ->visible(fn() => Auth::user()?->is_admin ?? false)
                ->schema([
                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->same('password_confirmation')
                        ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                        ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                        ->hint('Deixe em branco se não quiser alterar'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirmar Senha')
                        ->password()
                        ->required(fn(callable $get) => filled($get('password')))
                        ->dehydrated(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->searchable(),
                Tables\Columns\TextColumn::make('cpf')->label('CPF')->searchable(),
                Tables\Columns\TextColumn::make('telefone')->label('Telefone'),
                Tables\Columns\IconColumn::make('is_admin')->label('Admin')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => Auth::user()?->is_admin ?? false),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn() => Auth::user()?->is_admin ?? false),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
