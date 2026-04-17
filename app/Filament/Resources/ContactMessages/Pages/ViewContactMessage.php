<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->update(['is_read' => true]);
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('reply')
                ->label('Balas Email')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->url(fn () => 'mailto:' . $this->record->email . '?subject=Re: ' . urlencode($this->record->subject ?? 'Your message'))
                ->openUrlInNewTab(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
