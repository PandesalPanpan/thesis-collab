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
        // Possibly shorten if I create a method within the model to check current permission
        if (auth()->user()->role->permission_level >= $record->role->permission_level)
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
