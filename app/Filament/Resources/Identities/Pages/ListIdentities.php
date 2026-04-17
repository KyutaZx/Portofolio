<?php

namespace App\Filament\Resources\Identities\Pages;

use App\Filament\Resources\Identities\IdentityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIdentities extends ListRecords
{
    protected static string $resource = IdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
