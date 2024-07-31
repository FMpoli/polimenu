<?php

namespace Detit\Polimenu\Commands;

use Illuminate\Console\Command;

class PolimenuCommand extends Command
{
    public $signature = 'polimenu';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
