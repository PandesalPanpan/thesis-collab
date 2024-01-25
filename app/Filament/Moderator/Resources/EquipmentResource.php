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

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Forms\Components\Select::make('status')
                    ->options([
                        'stock' => 'Stock',
                        'borrowed' => 'Borrowed',
                        'unavailable' => 'Unavailable',
                        'missing' => 'Missing',
                    ])
                    ->default('stock'),
                TextInput::make('barcode')
                    ->label('Barcode'),
                TextInput::make('rfid')
                    ->label('RFID'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Borrowed by"),
                Tables\Columns\TextColumn::make('barcode'),
                Tables\Columns\TextColumn::make('rfid'),
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
