<?php
namespace Jasekz\RentalsUnitedCaching\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RentalsUnited;

class PutAvbUnitsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'rentals_united:put_avb_units  {--id=} {--from=} {--to=} {--u=} {--ms=} {--c=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upload availability, minimum stay and changeover for a property and specified date ranges.  Ex: rentals_united:put_avb_units --id="2726736" --from="2020-08-01" --to="2020-08-02" --u="1" --ms="1" --c"4"';

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
        /*
         * Option to check for updates 'since' given date/time
         * Argument passed in can be an valid php strtotime arg - http://php.net/manual/en/function.strtotime.php
         * 
         * Rentals United Update available units
         * https://developer.rentalsunited.com/#upload-available-units
         * 
         * Examples:
         * artisan rentals_united:put_avb_units --id="2726736" --from="2020-08-01" --to="2020-08-02" --u="1" --ms="1" --c"4"
         */ 

        $this->info(date('Y-m-d H:i:s', time()));
        $this->info("\tRU PutAvbUnits");

        $propId = $this->option('id');
        $dateFrom = $this->option('from');
        $dateTo = $this->option('to');
        $argu = $this->option('u');
        $argms = $this->option('ms');
        $argc = $this->option('c');

        if(!$this->option('id')) {
            $this->info("\tError no property id");
            return;
        }

        RentalsUnited::dataLoader()->putAvbUnits($propId, $dateFrom, $dateTo, $argu, $argms, $argc);

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
