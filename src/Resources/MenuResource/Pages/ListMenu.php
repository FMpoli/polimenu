<?php

namespace Detit\Polimenu\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Detit\Polimenu\Resources\MenuResource;

class ListMenu extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
