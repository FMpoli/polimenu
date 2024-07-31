<?php

namespace Detit\Polimenu\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Detit\Polimenu\Resources\MenuResource;

class CreateMenu extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = MenuResource::class;

    protected function afterSave(): void
    {
        // Qualsiasi logica aggiuntiva dopo il salvataggio
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
