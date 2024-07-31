<?php

namespace Detit\Polimenu;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Detit\Polimenu\Resources\MenuResource;

class PolimenuPlugin implements Plugin
{
    public function getId(): string
    {
        return 'polimenu';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                MenuResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
