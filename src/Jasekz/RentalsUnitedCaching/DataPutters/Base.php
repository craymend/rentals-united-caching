<?php
namespace Jasekz\RentalsUnitedCaching\DataPutters;

use RentalsUnited;
use Jasekz\RentalsUnitedCaching\Lib\RentalsUnited as RentalsUnitedLib;

class Base {

    /**
     * Constructor
     *
     * @param mixed $args            
     */
    public function __construct($args = null)
    {
        $this->ru = new RentalsUnitedLib(config('rentals_united_caching.RENTALS_UNITED_USERNAME'), config('rentals_united_caching.RENTALS_UNITED_PASSWORD'));
    }
}