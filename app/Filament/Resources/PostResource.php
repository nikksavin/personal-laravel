<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Forms\Components\Section::make('Information')
                            ->collapsible()
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->autofocus()
                                    ->required()
                                    ->debounce()
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                Forms\Components\Toggle::make('active')
                                    ->required(),
                                Forms\Components\FileUpload::make('cover'),
                                Forms\Components\TextInput::make('slug')
                                    ->readOnly()
                                    ->required(),
                                Forms\Components\RichEditor::make('content')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('posts')
                                    ->columnSpan(2),
                            ]),
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Metadata')
                            ->collapsible()
                            ->schema([
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('cover')->square(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
