<?php
 
namespace App\Filament\Moderator\Pages;

use App\Filament\Moderator\Widgets\UserMultiWidget;
use Filament\Widgets;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
       return [
            Widgets\AccountWidget::class,
            UserMultiWidget::class
       ];
    }
}