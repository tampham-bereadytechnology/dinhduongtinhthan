<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Log;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Blogs';

    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextInput::make('slug')
                            ->placeholder('Auto generated from name')
                            ->dehydrated(false),
                        TextInput::make('name')
                            ->helperText('Name cannot exceed 255 characters')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                        Textarea::make('description')
                            ->helperText('Description should have at least 50 characters and cannot exceed 255 characters')
                            ->minLength(50)
                            ->maxLength(255)
                            ->reactive(),
                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('thumbnails')
                            ->disk('public')
                            ->optimize('webp')
                            ->reactive(),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_name')
                            ->helperText('Meta name should have at least 20 characters and cannot exceed 100 characters')
                            ->minLength(20)
                            ->maxLength(100)
                            ->reactive(),
                        Textarea::make('meta_desc')
                            ->helperText('Meta description should have at least 50 characters and cannot exceed 190 characters')
                            ->minLength(50)
                            ->maxLength(190)
                            ->reactive()
                    ]),
                Section::make('Option')
                    ->schema([
                        Toggle::make('is_published'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable(),
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->width(50)
                    ->height(50),
                ToggleColumn::make('is_published')
                    ->label('Published'),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('updatedBy.name')
                    ->label('Updated By')
                    ->sortable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view_category');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('create_category');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasPermissionTo('update_category');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasPermissionTo('delete_category');
    }
}
