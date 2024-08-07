<?php

namespace App\Filament\Moderator\Resources\UserResource\RelationManagers;

use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Facades\LogBatch;

class EquipmentsRelationManager extends RelationManager
{

    protected static string $relationship = 'equipments';
    protected static ?string $inverseRelationship = 'user';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label('Equipment')
                    ->options([Equipment::whereNull('user_id')->pluck('name','barcode')
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable()
                    ->url(fn(Equipment $record): string => route('barcode', ['barcode' => $record->barcode]))
                    ->openUrlInNewTab()
                    ->formatStateUsing(function ($record){
                        $barcode = DNS1D::getBarcodeHTML($record->barcode, 'C128');
                        return $barcode;
                    })->html()
                    ->wrap(),
                Tables\Columns\TextColumn::make('borrow_date_start')
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrow_date_return_deadline')
                    ->sortable(),
                Tables\Columns\TextColumn::make('noted_instructor')
                    ->placeholder('No Instructor'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Borrow')
                    ->form([
                        Select::make('name')
                            ->label('Name of Equipment to be borrowed')
                            ->multiple()
                            ->helperText('Scan Barcode or manually type')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Equipment::query()
                            ->where('name', 'like', "%{$search}%")->whereNull('user_id')
                            ->orWhere('barcode', 'like', "%{$search}%")->whereNull('user_id')
                            ->limit(50)
                            ->pluck('name','id')
                            ->toArray())
                            ->preload()
                            ->required(),
                        Textarea::make('borrow_purpose')
                            ->label("Purpose for borrowing")
                            ->required(),
                        TextInput::make('noted_instructor')
                            ->label("Noted by Instructor"),
                        DateTimePicker::make('borrow_date_return_deadline')
                            ->format('Y-m-d H:i:s')
                            ->seconds(false)
                            ])
                    ->action(function (array $data, Equipment $equipment): void{
                        DB::transaction(function () use ($data){
                            $user = $this->getOwnerRecord();
                            LogBatch::startBatch();

                            foreach ($data["name"] as $value){ //$data['name'] is primary id
                                $equipment = Equipment::whereIn('id', [$value])->first();
                                $equipment_original = $equipment->getOriginal();
                                $equipment->user()->associate($user);
                                $equipment->borrow_purpose = $data["borrow_purpose"];
                                $equipment->borrow_date_start = now()->format('Y-m-d H:i:s');
                                $equipment->borrow_date_return_deadline = $data['borrow_date_return_deadline'];
                                $equipment->noted_instructor = $data['noted_instructor'];
                                $equipment->increment('borrowed_count');
                                $equipment->save();
                                activity()
                                    ->causedBy(auth()->user()) // Assuming you have user authentication
                                    ->withProperties([
                                        'attributes' => $equipment->getChanges(),
                                        'old' => $equipment_original,

                                    ])
                                    ->event('borrow')
                                    ->useLog('Borrow')
                                    ->on($equipment)
                                    ->log('borrow equipment');
                            }
                            LogBatch::endBatch();
                        });

                    })
            ])
            ->actions([
                Action::make('Return')
                    ->color("success")
                    ->icon('heroicon-o-hand-raised')
                    ->requiresConfirmation()
                    ->successNotificationTitle('Successfully Returned')
                    ->action(function (Equipment $record) {
                        DB::transaction(function () use ($record){
                            LogBatch::startBatch();
                            LogBatch::setBatch($this->getBatchUuid($record));

                            $this->dissociateAndLog($record);
                            LogBatch::endBatch();
                        });

                    }),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\BulkAction::make('Return')
                        ->label('Return Selected')
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->icon('heroicon-o-hand-raised')
                        ->action(function (Collection $records){
                            DB::transaction(function () use ($records){
                                LogBatch::startBatch();
                                LogBatch::setBatch($this->getBatchUuid($records[0]));
                                $records->each(function (Equipment $record): void {
                                    $this->dissociateAndLog($record);
                                });
                                LogBatch::endBatch();
                            });
                        })
            ]);
    }

    private function dissociateAndLog(Equipment $record): void
    {
        $record_original = $record->getOriginal();
        $record->user()->dissociate();
        $record->borrow_last_returned = now();
        $record->borrow_purpose = null;
        $record->borrow_date_start = null;
        $record->borrow_date_return_deadline = null;
        $record->noted_instructor = null;
        $record->save();
        activity()
            ->causedBy(auth()->user()) // Assuming you have user authentication
                ->withProperties([
                    'attributes' => $record,
                    'old' => $record_original,
                ])
                ->event('return')
                ->useLog('Returns')
                ->on($record)
                ->log('return');
    }

    private function getBatchUuid(Equipment $record)
    {
        return Activity::where('subject_id', $record->id)
            ->where('event','borrow')
            ->latest()
            ->value('batch_uuid');
    }
}
