<?php

namespace App\Filament\Resources\Identities\Pages;

use App\Filament\Resources\Identities\IdentityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIdentity extends EditRecord
{
    protected static string $resource = IdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
