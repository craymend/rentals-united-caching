<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class DepositTypes extends Base  {

    protected $table = 'RentalsUnited_DepositTypes';
    
    protected  $primaryKey = 'DepositTypeID';
    
    public function props()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\Prop', 'DepositTypeID', 'DepositTypeID');
    }

    /**
     * <DepositType DepositTypeID="1">No deposit</DepositType>
     * <DepositType DepositTypeID="2">Percentage of total price (without cleaning)</DepositType>
     * <DepositType DepositTypeID="3">Percentage of total price</DepositType>
     * <DepositType DepositTypeID="4">Fixed amount per day</DepositType>
     * <DepositType DepositTypeID="5">Flat amount per stay</DepositType>
     * 
     * @return number
     */
    public static function getDepositAmount($depositTypeId, $depositValue, $amount){
        $depositAmount = $amount;

        switch($depositTypeId){
            case 1:
                $depositAmount = 0;
                break;
            case 2:
            case 3:
                $depositAmount = $amount * ($depositValue/100);
                break;
            case 4:
            case 5:
                $depositAmount = $depositValue;
                break;
            default:
                break;
        }

        return $depositAmount;
    }
}