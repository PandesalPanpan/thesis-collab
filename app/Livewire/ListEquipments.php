<?php

namespace App\Livewire;

use App\Models\Equipment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
//use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Component;
 

class ListEquipments extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->query(Equipment::query()
                ->whereNull('user_id'))
            ->columns([
                ImageColumn::make('image'),
                //SpatieMediaLibraryImageColumn::make('equipment-image')
                  //  ->label('Image'),
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.list-equipments');
    }
}
?>