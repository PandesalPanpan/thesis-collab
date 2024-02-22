<?php

namespace App\Filament\Moderator\Resources;

use App\Filament\Moderator\Resources\LogResource\Pages;
use App\Filament\Moderator\Resources\LogResource\RelationManagers;
use App\Models\Log;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogResource extends Resource
{
    protected static ?string $model = Log::class;
    protected static ?string $label = "RFID Logs";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    /* For Mozo: Dinsable q ung manual creation pero im not sure if ididisable din neto if u created
       a record sa table in some other way*/
       // Source: https://stackoverflow.com/questions/74999545/remove-create-button-inside-filamentphp-view
    public static function canCreate(): bool 
   {
      return false;
   }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogs::route('/'),
            'create' => Pages\CreateLog::route('/create'),
            'edit' => Pages\EditLog::route('/{record}/edit'),
        ];
    }
}
