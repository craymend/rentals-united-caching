<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class Reservation extends Base {

    protected $table = 'RentalsUnited_Reservations';
    
    protected  $primaryKey = 'ID';
}