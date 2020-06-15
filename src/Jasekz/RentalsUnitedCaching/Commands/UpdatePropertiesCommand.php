<?php
namespace Jasekz\RentalsUnitedCaching\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RentalsUnited;


class UpdatePropertiesCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rentals_united:update_properties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache property updates. Ex: rentals_united:update_properties --since="-1 month"';

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
        $datetime = null;        
        
        /*
         * Option to check for updates 'since' given date/time.
         * Local RentalsUnited_PropertyChangeLog records are checked, not RU API.
         * Because of this you may want to update the local changelog before using 
         * this command.
         * 
         * Argument passed in can be an valid php strtotime arg - http://php.net/manual/en/function.strtotime.php
         * 
         * Examples:
         * artisan rentals_united:update_properties --since="-1 month"
         * artisan rentals_united:update_properties --since="2014-03-26 12:51:00"
         * 
         * When no option is passed, the default is -10 minutes
         */ 
        if($this->option('since')) {
            $datetime = date('Y-m-d H:i:s', strtotime($this->option('since')));
        }else{
            $datetime = date('Y-m-d H:i:s', strtotime('-1 day'));
        }

        $this->info(date('Y-m-d H:i:s', time()));
        $this->info("\tUpdate RU property data using changelog since {$datetime}");

        // Update change logs for all properties
        RentalsUnited::dataLoader()->updateProperties( $datetime );

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
