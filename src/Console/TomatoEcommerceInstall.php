<?php

namespace TomatoPHP\TomatoEcommerce\Console;

use Illuminate\Console\Command;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

use TomatoPHP\TomatoEcommerce\Services\TomatoEcommerceSectionsBuilder;

class TomatoEcommerceInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'tomato-ecommerce:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Publish Vendor Assets');
        $this->artisanCommand(["migrate"]);
        $this->artisanCommand(["optimize:clear"]);
        TomatoEcommerceSectionsBuilder::build();
        $this->info('Tomato Ecommerce installed successfully.');
    }
}
