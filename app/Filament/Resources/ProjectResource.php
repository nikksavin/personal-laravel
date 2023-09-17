<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;



class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'My projects';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
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
                                    ->fileAttachmentsDirectory('projects')
                                    ->columnSpan(2),
                            ]),
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Metadata')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->searchable()
                                    ->relationship('category', 'title')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->debounce()
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->readOnly()
                                            ->unique()
                                            ->required(),
                                    ]),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ]),
                    ]),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('cover')->square(),
                Tables\Columns\TextColumn::make('category.title'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->alignCenter(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
