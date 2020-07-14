<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class AdditionalFeeDiscriminators extends Base  {

    protected $table = 'RentalsUnited_AdditionalFeeDiscriminators';
    
    protected  $primaryKey = 'ID';

    public function getValueDisplay($value){
        $ret = '';

        switch($this->ID){
            case 1:
                $ret = '$' . number_format($value, 2, '.', '');
                break;
            case 2:
                $ret = $value . ' per day';
                break;
            case 3:
                // independent
                $ret = $value * 100 . '%';
                break;
            case 4:
                // cumulative
                $ret = $value * 100 . '%';
                break;
            case 5:
                $ret = '$' . number_format($value, 2, '.', '') . ' per person';
                break;
            case 6:
                $ret = '$' . number_format($value, 2, '.', '') . ' per person, per day';
                break;
            case 7:
                $ret = '$' . number_format($value, 2, '.', '') . ' per person, per day';
                break;
            case 8:
                $ret = '$' . number_format($value, 2, '.', '') . ' per week';
                break;
            case 9:
                // variable amount by consumption
                $ret = '$' . number_format($value, 2, '.', '');
                break;
            case 10:
                // variable amount by use
                $ret = '$' . number_format($value, 2, '.', '');
                break;
            case 11:
                // fixed per set
                $ret = '$' . number_format($value, 2, '.', '');
                break;
            case 12:
                // fixed per set per week
                $ret = '$' . number_format($value, 2, '.', '');
                break;
            case 13:
                // independent percentage per day
                $ret = $value * 100 . '% per day';
                break;
            case 14:
                // independent percentage per person
                $ret = $value * 100 . '% per person';
                break;
        }

        return $ret;
    }
}