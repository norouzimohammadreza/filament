<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\ActivityLogRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\LogsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('filament\dashboard.users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament\dashboard.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()
                    ->label(__('filament\user.name'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->required()
                    ->label(__('filament\user.email'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')->required()
                    ->password()
                    ->label(__('filament\user.password'))
                    ->minLength(6)
                    ->visibleOn('create')
                    ->maxLength(12),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->label(__('filament\user.confirm_password'))
                    ->required()
                    ->visibleOn('create')
                    ->same('password'),

                Forms\Components\Select::make('role')
                    ->label(__('filament\user.role'))
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label(__('filament\user.name')),
                TextColumn::make('email')->searchable()->label(__('filament\user.email')),
                TextColumn::make('roles.name')->searchable()->label(__('filament\user.role')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make(__('filament\user.change_password'))
                    ->icon('heroicon-o-check-circle')
                    ->form([
                        Forms\Components\TextInput::make('password')->required()
                            ->password()
                            ->label(__('filament\user.password'))
                            ->minLength(6)
                            ->maxLength(12),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->label(__('filament\user.confirm_password'))
                            ->required()
                            ->same('password'),

                    ])
                    ->action(function (User $user, array $data): void {
                        $user->password = Hash::make($data['password']);
                        $user->save();
                        Notification::make()->title('کلمه عبور با موفقیت تغییر کرد.')
                            ->success()
                            ->send();
                    })

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
            LogsRelationManager::class,
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
