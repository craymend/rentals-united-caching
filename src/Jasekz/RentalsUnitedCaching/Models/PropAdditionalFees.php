<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class PropAdditionalFees extends Base {

    protected $table = 'RentalsUnited_PropAdditionalFees';
    
    protected  $primaryKey = 'ID';
    
    public function prop()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Prop', 'PropID', 'ID');
    }

    public function kind()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\AdditionalFeeKinds', 'KindID', 'ID');
    }

    public function discriminator()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\AdditionalFeeDiscriminators', 'DiscriminatorID', 'ID');
    }

    public function feeTaxType()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\AdditionalFeeTypes', 'FeeTaxType', 'ID');
    }
}