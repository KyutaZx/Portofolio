<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class HeaderWidget extends Widget
{
    protected string $view = 'filament.widgets.header-widget';

    protected int | string | array $columnSpan = 'full';

    // The sorting order on the dashboard
    protected static ?int $sort = 1;

    protected function getViewData(): array
    {
        return [
            'projectsCount' => \App\Models\Project::count(),
            'certsCount' => \App\Models\Certification::count(),
        ];
    }
}
