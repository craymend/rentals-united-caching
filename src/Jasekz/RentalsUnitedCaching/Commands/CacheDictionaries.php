<?php
namespace Jasekz\RentalsUnitedCaching\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RentalsUnited;


class CacheDictionaries extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rentals_united:cache_dictionaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache RU dictionary data.';

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
        $this->info("\tCache RU dictionary data");

        RentalsUnited::dataLoader()->cacheDictionaries();

        $this->info(""); // newline
    }
 
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getOptions()
    {
        return array(
            array('since', 'since', InputOption::VALUE_OPTIONAL),
        );
    }

    public function handle(){
        $this->fire();
    }
}
