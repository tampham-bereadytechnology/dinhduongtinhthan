<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Facades\Filament;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Roles and Permissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('password')
                    ->password()
                    ->nullable()
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? Hash::make($state) : null),

                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->options(
                       auth()->user()->hasRole('Admin')
                       ?Role::where('name', '!=', 'Super Admin')->pluck('name','id')->toArray() : Role::pluck('name','id')->toArray()
                    )
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('roles')
                    ->label('Roles')
                    ->getStateUsing(fn($record) => $record->getRoleNames()->join(', ')),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(fn($record) => $record->delete())
                    ->requiresConfirmation('Are you sure you want to delete this user?')
                    ->successNotificationTitle('Post deleted successfully!'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view_user');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('create_user');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasPermissionTo('update_user');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasPermissionTo('delete_user');
    }
}
