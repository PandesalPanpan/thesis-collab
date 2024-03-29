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
use Illuminate\Support\Facades\DB;

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
                    ->options([Equipment::whereNull('user_id')->pluck('name','barcode')
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        //ddd(Equipment::query()->whereNull('user_id')->pluck('barcode','name')->toArray());
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Borrow')
                    ->form([
                        Forms\Components\Select::make('name')
                            ->multiple()
                            ->helperText('Scan Barcode or manually type')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Equipment::query()
                            //->getOptionLabelUsing(fn ($value): ?string => Equipment::find($value)?->name)
                            ->where('name', 'like', "%{$search}%")->whereNull('user_id')
                            ->orWhere('barcode', 'like', "%{$search}%")->whereNull('user_id')
                            ->limit(50)
                            ->pluck('name','id')
                            ->toArray())
                            ->preload(),
                        Forms\Components\Textarea::make('borrow_purpose')
                            ->label("Purpose for borrowing")
                            ->required()
                            ])
                            // ->options(Equipment::query()
                            //     ->whereNull('user_id')
                            //     ->pluck('name','barcode')

                            //     ->options(Equipment::query()
                            //         ->select([
                            //             DB::raw("CONCAT(name, ' ', barcode) as namecode"), 'barcode',
                            //         ])
                            //         ->whereNull('user_id')
                            //         ->pluck('namecode','barcode')
                            //         ->toArray())
                            // ->searchable()


                    ->action(function (array $data, Equipment $equipment): void{
                        DB::transaction(function () use ($data){
                            $user = $this->getOwnerRecord();
                            // ddd($data);
                            // ddd($data["name"]);
                            foreach ($data["name"] as $value){
                                $equipment = Equipment::whereIn('id', [$value])->first();
                                $equipment->user()->associate($user);
                                $equipment->borrow_purpose = $data["borrow_purpose"];
                                $equipment->save();
                            }
                        });
                        
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
            // TODO: Possibly need to customize the disassociate to remove the borrow purpose
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
