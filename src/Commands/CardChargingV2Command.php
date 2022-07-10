<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Commands;

use Illuminate\Console\Command;

class CardChargingV2Command extends Command
{
    public $signature = 'card-charging-v2';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
