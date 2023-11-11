<?php

namespace Onuraycicek\Currency\Commands;

use Illuminate\Console\Command;

class CurrencyCommand extends Command
{
    public $signature = 'currency';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
