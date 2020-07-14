<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class ReservationStayInfos extends Base {

    protected $table = 'RentalsUnited_ReservationStayInfos';
    
    protected  $primaryKey = 'ID';

    public function reservation()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Reservation', 'ReservationID', 'ReservationID');
    }

    public function prop()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Prop', 'PropID', 'ID');
    }
}