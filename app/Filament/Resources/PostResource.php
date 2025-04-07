<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Blogs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Information')
                    ->schema([
                        TextInput::make('slug')
                            ->placeholder('Auto generated from name')
                            ->dehydrated(false),
                        TextInput::make('name')
                            ->helperText('Name should have at least 20 characters and cannot exceed 255 characters')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('description')
                            ->helperText('Description should have at least 50 characters and cannot exceed 255 characters'),
                        Select::make('category_id')
                            ->placeholder('Select a category')
                            ->Label('Category')
                            ->relationship('category', 'name')
                            ->preload()
                            ->required(),
                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('thumbnails')
                            ->disk('public')
                            ->optimize('webp'),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_name')
                            ->helperText('Meta title should have at least 20 characters and cannot exceed 100 characters'),
                        TextInput::make('meta_desc')
                            ->helperText('Meta description should have at least 50 characters and cannot exceed 190 characters'),
                    ]),
                Section::make('Content')
                    ->schema([
                        TinyEditor::make('content')
                            ->minHeight(400)
                            ->showMenuBar()
                            ->toolbarSticky(true)
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads'),
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
                //
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->thumbnail)),
                ToggleColumn::make('is_published')
                    ->label('Published')
                    ->sortable(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),

        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view_blog');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('create_blog');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasPermissionTo('update_blog');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasPermissionTo('delete_blog');
    }
}
