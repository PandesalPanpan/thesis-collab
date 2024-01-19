<?php

namespace App\Filament\Moderator\Resources\UserResource\RelationManagers;

use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Moderator\Resources\UserResource\RelationManagers\AssociateAction;

class EquipmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'equipments';
    protected static ?string $inverseRelationship = 'user';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('name')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\Select::make('name')
                    ->label('Equipment')
                    ->options([Equipment::whereNull('user_id')->pluck('name')
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
