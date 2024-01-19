<?php
namespace Jasekz\RentalsUnitedCaching\Models;

class AdditionalFeeTypes extends Base  {

    protected $table = 'RentalsUnited_AdditionalFeeTypes';
    
    protected  $primaryKey = 'ID';

    /**
     * Rentals United doesn't encode if an AdditionalFeeType is a 
     *   tax or a fee so we have to hardcode it here.
     * 
     *   <AdditionalFeeTypeInfo ID="1">local tax</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="2">VAT</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="3">tourist tax</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="4">goods and services tax</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="5">city tax</AdditionalFeeTypeInfo>
     * 
     * @return array
     */
    public static function getTaxTypeIds(){
        return [1,2,3,4,5];
    }

    /**
     * Rentals United doesn't encode if an AdditionalFeeType is a 
     *   tax or a fee so we have to hardcode it here.
     * 
     *   <AdditionalFeeTypeInfo ID="6">Towels fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="7">Electricity fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="8">Bed linen fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="9">Gas fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="10">Oil fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="11">Wood fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="12">Water usage fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="13">Transfer fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="14">Linen package fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="15">Heating fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="16">Air conditioning fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="17">Kitchen linen fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="18">Housekeeping fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="19">Airport shuttle fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="20">Shuttle boat fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="21">Sea plane fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="22">Ski pass</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="23">Wristband fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="24">Visa support fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="25">Water park fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="26">Club card fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="27">Conservation fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="28">Credit card fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="29">Pet fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="30">Internet fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="31">Parking fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="32">Insurance</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="33">Service fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="34">Resort fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="35">Booking fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="36">Tourism fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="37">Destination fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="38">Extra bed fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="39">Environment fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="40">Children extra fee</AdditionalFeeTypeInfo>
     *   <AdditionalFeeTypeInfo ID="41">Cleaning fee</AdditionalFeeTypeInfo>
     * 
     * @return array
     */
    public static function getFeeTypeIds(){
        return [
            6, 7, 8, 9, 
            10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 
            20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 
            30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 
            40, 41
        ];
    }
}