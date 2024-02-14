<?php

namespace App\Filament\Moderator\Resources\UserResource\Pages;

use App\Filament\Moderator\Resources\UserResource;
use App\Models\Role;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (auth()->user()->role_id >= $record->role_id) // 4 >= 3
        {
            DB::transaction(function () use ($record, $data){
                $record->update($data);
                return $record;
            });
        }else{
            Notification::make()
                ->title('Save unsuccessful: Your role level is equal to or lower than the required level')
                ->warning()
                ->send();
            $this->halt();
        }
        return $record;
 //Return record without updating
    }
    protected function getHeaderActions(): array
    {
        //Quick fix is to only allow admins to delete
            return [
                Actions\DeleteAction::make()
                    ->disabled(!auth()->user()->isAdmin()),
            ];
        

    }
}
