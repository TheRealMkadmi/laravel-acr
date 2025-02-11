<?php

namespace TheRealMkadmi\LaravelAcr\Commands;

use Illuminate\Console\Command;

class LaravelAcrCommand extends Command
{
    public $signature = 'laravel-acr';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
