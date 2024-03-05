<?php

namespace App\Filament\Moderator\Widgets;

use App\Filament\Moderator\Resources\ModeratorResource\Widgets\LatestBorrows;
use App\Filament\Moderator\Widgets\LatestReturns;
use App\Filament\Moderator\Widgets\MostBorrowed;
use Kenepa\MultiWidget\MultiWidget;

class UserMultiWidget extends MultiWidget
{
    public array $widgets = [
        LatestBorrows::class,
        LatestReturns::class,
        MostBorrowed::class,
    ];
}
