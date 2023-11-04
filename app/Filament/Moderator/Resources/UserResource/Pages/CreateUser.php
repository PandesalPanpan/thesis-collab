<?php

namespace App\Filament\Moderator\Resources\UserResource\Pages;

use App\Filament\Moderator\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
