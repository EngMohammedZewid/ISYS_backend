<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SessionResource\Pages;
use App\Filament\Resources\SessionResource\RelationManagers\TranslationsRelationManager;
use App\Models\Session;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'Agenda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TimePicker::make('from')
                    ->required(),
                Forms\Components\TimePicker::make('to')
                    ->required(),
                Forms\Components\TextInput::make('link')
                    ->rules('url'),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->downloadable()
                    ->directory('uploads')
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('sessions-'),
                    ),
                Forms\Components\TextInput::make('live_link')
                    ->rules('url'),
                Forms\Components\TextInput::make('speaker')
                    ->maxLength(255),
                Forms\Components\TextInput::make('speaker_job_title')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->default(false),
                Select::make('track_id')
                    ->relationship(name: 'track', titleAttribute: 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record): string => (string) ($record->title ?? ('Track #' . $record->id))
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('track.title'),
                Tables\Columns\TextColumn::make('link'),
                Tables\Columns\ImageColumn::make('image')->circular()->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('from'),
                Tables\Columns\TextColumn::make('to'),
                Tables\Columns\TextColumn::make('date'),
                Tables\Columns\ToggleColumn::make('is_active'),
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
            TranslationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSessions::route('/'),
            'create' => Pages\CreateSession::route('/create'),
            'edit' => Pages\EditSession::route('/{record}/edit'),
        ];
    }
}
