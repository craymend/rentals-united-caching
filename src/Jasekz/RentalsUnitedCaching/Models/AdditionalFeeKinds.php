<?php

/**
 * DEPRECATED
 * 
 * AdditionalFeeKinds is already deprecated. Use AdditionalFeeTypes instead.
 */

namespace Jasekz\RentalsUnitedCaching\Models;

class AdditionalFeeKinds extends Base  {

    protected $table = 'RentalsUnited_AdditionalFeeKinds';
    
    protected  $primaryKey = 'ID';

    // Rentals United doesn't encode if an AdditionalFeeKind is a tax 
    //   or a fee so we have to hardcode it here.
    const KIND_TAX = 1;
    const KIND_FEE = 2;
}