<?php

namespace App\Filament\Moderator\Resources\UserResource\RelationManagers;

use App\Models\Equipment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\AssociateAction;

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
                Tables\Actions\AssociateAction::make()
                    ->recordSelect(fn (Select $select) => $select->multiple()),
                    //->recordSelectSearchColumns(['name', 'barcode']),
                Tables\Actions\Action::make('Borrow')
                    ->form([
                        Forms\Components\Select::make('barcode')
                            ->searchable()
                            ->multiple()
                            ///where('barcode') is what is searched and pluck('name') is what appears
                            ->getSearchResultsUsing(fn (string $search): array => Equipment::where('barcode', 'like', "%{$search}%")->limit(50)->pluck('name')->toArray())
                    ]),
                Tables\Actions\Action::make('Borrow Test')
                    ->form([
                        Forms\Components\Select::make('name')
                            ->searchable()
                            ->options(Equipment::query()->pluck('name','barcode'))
                            //->getSearchResultsUsing(fn (string $search): array => Equipment::where('barcode', 'like', "%{$search}%")->limit(50)->pluck('name')->toArray())
                    ])
                    ->action(function (array $data, Equipment $equipment): void{
                        $user = User::find(1);
                        $equipment->user()->associate($user);
                        $equipment->save();
                    })
                /* 
                Eto Jocel Cucustomize mo toh either gawa ka ng custom form field
                or pwede ding laravel middleware, need aralin talaga
                Sample Demonstration
                Student Assistance clicks "Associate" -> Select Equipment 
                -> Either open the fingerprint scanner app and verifies fingerprint na valid
                or sa middleware where kapag cinofirm don na lalabas ung fingerprint scanner then verifies
                */
            ])
            ->actions([
                Tables\Actions\DissociateAction::make(),
                // Dito rin jocel ikakabit fingerprint
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }
}
