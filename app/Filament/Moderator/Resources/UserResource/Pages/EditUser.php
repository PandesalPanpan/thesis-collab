<?php

namespace App\Filament\Moderator\Resources\UserResource\Pages;

use App\Filament\Moderator\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
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
        if (auth()->user()->role->permission_level > $this->getOriginalPermission($record) || auth()->user()->isAdmin())
        {
            DB::transaction(function () use ($record, $data){
                $record->update($data);
                return $record;
            });
        }else{
            Notification::make()
                ->title('Save unsuccessful: Only Laboratory Head can make changes to moderators')
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

    private function getOriginalPermission($currentRecord): int
    {
        $original = $currentRecord->getOriginal(); 
        return $original_permission_level = User::find($original['id'])->role->permission_level;
    }
}
