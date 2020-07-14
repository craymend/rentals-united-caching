<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class PropAvbCalendar extends Base {

    protected $table = 'RentalsUnited_PropertyAvailabilityCalendar';
    
    protected  $primaryKey = 'ID';
    
    public function prop()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Prop', 'PropID', 'ID');
    }
}