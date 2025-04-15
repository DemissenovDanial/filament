<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use App\Models\ArticleCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Статьи';

    protected static ?string $modelLabel = 'Статьи';

    protected static ?string $pluralModelLabel = 'Статьи';

    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('preview_image')
                    ->image()
                    ->directory('articles')
                    ->required(),
                Forms\Components\FileUpload::make('detail_image')
                    ->image()
                    ->directory('articles')
                    ->required(),
                Forms\Components\Textarea::make('preview_text')
                    ->required()
                    ->columnSpanFull(),
                TinyEditor::make('detail_text')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('tags')
                    ->label('Теги')
                    ->multiple()
                    ->relationship('tags', 'title')
                    ->preload(),
                Forms\Components\Select::make('category_id')
                    ->options(static::categoryOptions())
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->default(Carbon::now())
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\ImageColumn::make('preview_image'),
                Tables\Columns\ImageColumn::make('detail_image'),
                Tables\Columns\TextColumn::make('category.title')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags')
                    ->label('Теги')
                    ->getStateUsing(function ($record) {
                        return $record->tags->isNotEmpty()
                            ? $record->tags->pluck('title')->implode(', ')
                            : 'Нет тегов';
                    }),


                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function categoryOptions()
    {
        return ArticleCategory::pluck('title', 'id');
    }
}
