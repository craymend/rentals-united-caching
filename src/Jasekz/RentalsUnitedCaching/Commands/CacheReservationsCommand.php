<?php
namespace Jasekz\RentalsUnitedCaching\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RentalsUnited;


class CacheReservationsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    // protected $name = 'rentals_united:cache_reservations';
    protected $signature = 'rentals_united:cache_reservations {--since=} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache reservations. Ex: rentals_united:cache_reservations --since="-1 day"';

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
        $this->info("\tCache RU reservations");

        $datetime = null;

        /*
         * Option to check for updates 'since' given date/time
         * Argument passed in can be an valid php strtotime arg - http://php.net/manual/en/function.strtotime.php
         * 
         * Examples:
         * artisan rentals_united:cache_reservations --since="-1 month"
         * artisan rentals_united:cache_reservations --since="2014-03-26 12:51:00"
         * 
         * When no option is passed, the default is -1 day
         * 
         * Note: Date range is limited to 7 days. From Rentals United Docs:
         *   "Under no circumstances should your date range be greater than 7 days. 
         *   The result set will be cut to reservations created or modified maximum 7 days in the past."
         * 
         * Note 2: Rentals United's Pull_ListReservations_RQ uses the reservation's 
         *   "Pull_ListReservations_RS/Reservations/Reservation/LastMod"
         *   for the date range query and NOT the reservation's 
         *   "Pull_ListReservations_RS/Reservations/Reservation/StayInfos/StayInfo/DateFrom".
         *   Probably this is becuase a reservation can have multiple bookings.
         */ 
        if($this->option('since')) {
            $dateFrom = date('Y-m-d H:i:s', strtotime($this->option('since')));
        }else{
            $dateFrom = date('Y-m-d H:i:s', strtotime('-1 day'));
        }
        $dateTo = date('Y-m-d H:i:s');

        $ids = null;
        if($this->option('id')) {
            $ids = explode(',', $this->option('id'));
        }

        if($ids) {
            foreach($ids as $id) {
                RentalsUnited::dataLoader()->cacheReservationById($id);
            }
        }else{
            // Update change logs for all properties
            RentalsUnited::dataLoader()->cacheReservations($dateFrom, $dateTo);
        }

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
