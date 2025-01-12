<?php

namespace Detit\Polimenu\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Detit\Polimenu\Resources\MenuResource;

class EditMenu extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = MenuResource::class;

    protected function afterSave(): void
    {
        // Qualsiasi logica aggiuntiva dopo il salvataggio
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
