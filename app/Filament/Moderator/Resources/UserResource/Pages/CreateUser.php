<?php

namespace App\Filament\Moderator\Resources\UserResource\Pages;

use App\Filament\Moderator\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    protected function afterCreate(): void
    {
        $user = $this->record;
        if ($user->role->permission_level > 1){
            $notification = new VerifyEmail();
            $notification->url = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ],
            );
            $user->notify($notification);
        }
    }
}
