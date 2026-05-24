<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeItemResource\Pages;
use App\Filament\Resources\KnowledgeItemResource\RelationManagers;
use App\Models\KnowledgeItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KnowledgeItemResource extends Resource
{
    protected static ?string $model = KnowledgeItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\FileUpload::make('image')->image()
                    ->required()->imageEditor()
                    ->imageCropAspectRatio('1:1'),
                Forms\Components\TextInput::make('url')->required()->maxLength(255)
                    ->url(),
                Forms\Components\Select::make('knowledge_category_id')->required()->relationship('knowledgeCategory', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('knowledgeCategory.name'),
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
            'index' => Pages\ListKnowledgeItems::route('/'),
            'create' => Pages\CreateKnowledgeItem::route('/create'),
            'edit' => Pages\EditKnowledgeItem::route('/{record}/edit'),
        ];
    }
}
