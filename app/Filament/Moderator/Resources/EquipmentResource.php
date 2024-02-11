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
//use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\FileUpload;
use Milon\Barcode\DNS1D;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;
    protected static bool $shouldSkipAuthorization = true;


    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('barcode')
                    ->label('Barcode'),
                TextInput::make('rfid')
                    ->label('RFID'),
                //Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                   // ->conversion('thumb'),
                FileUpload::make('image'),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
    return $table
            ->deferLoading()
            ->columns([
                //Tables\Columns\SpatieMediaLibraryImageColumn::make('equipment-image')
                  //  ->label('Image'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Borrowed by"),
                Tables\Columns\TextColumn::make('barcode')
                    ->formatStateUsing(function ($record){
                        $barcode = DNS1D::getBarcodeHTML($record->barcode, 'C128');
                        return $barcode;
                    })->html(),
                Tables\Columns\TextColumn::make('rfid')
                    ->label("RFID"),
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }    
}
