<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\TextInput::make('author_id')->hidden()->default(auth()->id()),
                    Forms\Components\TextInput::make('full_name')->label(__('auth.full_name'))
                        ->required()->maxLength(255),
                    Forms\Components\TextInput::make('phone')->tel()
                        ->mask(fn(Forms\Components\TextInput\Mask $mask) => $mask->pattern('+{998}(00)000-00-00'))
                        ->maxLength(18)->label(__('auth.phone_number'))->required(),
                Forms\Components\TextInput::make('password')->label(__('auth.enter_password'))
                    ->required()->password()
                    ->rules([Password::min(8)->letters()->numbers()]),
                Forms\Components\TextInput::make('password_confirm')->label(__('auth.confirm_password'))
                    ->required()->password()->same('password'),
                Forms\Components\TextInput::make('email')->email()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('phone_confirmed')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar.path_512'),
                Tables\Columns\TextColumn::make('full_name')->label(__('auth.full_name')),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\BooleanColumn::make('is_active'),
                Tables\Columns\BooleanColumn::make('phone_confirmed')
            ])
            ->filters([

            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
