<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class PropertyFSPPrice extends Base {

    protected $table = 'RentalsUnited_PropertyFSPPrices';
    
    protected  $primaryKey = 'ID';
    
    public function prop()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Prop', 'PropID', 'ID');
    }
}