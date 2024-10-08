<?php
namespace Jasekz\RentalsUnitedCaching\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RentalsUnited;


class CacheAllCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rentals_united:cache_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all Rentals United data. No options.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info(date('Y-m-d H:i:s', time()));
        $this->info("\tCache all RU data");

        // Cache from RU
        RentalsUnited::dataLoader()->cacheAll();

        $this->info(""); // newline
    }

    public function handle(){
        $this->fire();
    }
}
