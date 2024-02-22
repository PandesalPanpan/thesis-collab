<?php

namespace App\Filament\Moderator\Resources;

use App\Filament\Moderator\Resources\EquipmentResource\Pages;
use App\Filament\Moderator\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Milon\Barcode\DNS1D;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;
    // Di naman nagana?? maybe in case of ever requires logging in not admin/moderator
    //protected static bool $shouldSkipAuthorization = true; 
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('barcode')
                    ->label('Barcode')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('rfid')
                    ->label('RFID')
                    ->unique(ignoreRecord: true),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor(),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
    return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Borrowed by")
                    ->searchable()
                    ->placeholder("Not Borrowed"),
                Tables\Columns\TextColumn::make('barcode')
                    ->formatStateUsing(function ($record) {
                        dd($record->barcode); // Dump the barcode value
                        $barcode = DNS1D::getBarcodeHTML($record->barcode, 'C128');
                        return $barcode;
                    })->html(),
                Tables\Columns\TextColumn::make('rfid')
                    ->label("RFID"),
            ])
            ->filters([
                //
                TernaryFilter::make('user_id')
                    ->label('Borrow State')
                    ->placeholder('All')
                    ->trueLabel('Borrowed')
                    ->falseLabel('Unborrowed')
                    ->nullable()
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('user_id'),
                        false: fn (Builder $query) => $query->whereNull('user_id'),
                        blank: fn (Builder $query) => $query,
                    )
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }    
}
