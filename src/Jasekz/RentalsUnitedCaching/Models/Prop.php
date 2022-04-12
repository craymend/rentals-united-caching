<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use DB;

class Prop extends Base  {

    protected $table = 'RentalsUnited_Prop';
    
    protected  $primaryKey = 'ID';
    
    public function amenities()
    {
        return $this->belongsToMany('Jasekz\RentalsUnitedCaching\Models\Amenities', 'RentalsUnited_PropAmenities', 'PropID', 'AmenityID')->withPivot('Count');
    }
    
    public function arrivalInstructions()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\ArrivalInstructions', 'PropID', 'ID');
    }
    
    public function availabilityCalendar()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\AvailabilityCalendar', 'PropID', 'ID');
    }
    
    public function avbPrices()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\AvbPrices', 'PropID', 'ID');
    }
    
    public function basePrices()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\BasePrices', 'PropID', 'ID');
    }
    
    public function blocks()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\Blocks', 'PropID', 'ID');
    }
    
    public function building()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Buildings', 'BuildingID', 'BuildingID');
    }
    
    public function cancellationPolicies()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\CancellationPolicies', 'PropID', 'ID');
    }
    
    public function changeLog()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\ChangeLog', 'PropID', 'ID');
    }
    
    public function changeoverDays()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\ChangeoverDays', 'PropID', 'ID');
    }
    
    public function compositionRooms()
    {
        return $this->belongsToMany('Jasekz\RentalsUnitedCaching\Models\CompositionRooms', 'RentalsUnited_PropCompositionRooms', 'PropID', 'CompositionRoomID')->withPivot('Count');
    }
    
    public function depositType()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\DepositTypes', 'DepositTypeID', 'DepositTypeID');
    }
    
    public function descriptions()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\Descriptions', 'PropID', 'ID');
    }
    
    public function discountsLastMinute()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\DiscountsLastMinute', 'PropID', 'ID');
    }
    
    public function discountsLongStay()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\DiscountsLongStay', 'PropID', 'ID');
    }
    
    public function distances()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\Distances', 'PropID', 'ID');
    }
    
    public function earlyDepartureFees()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\EarlyDepartureFees', 'PropID', 'ID');
    }
    
    public function externalListings()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\ExternalListings', 'PropID', 'ID');
    }
    
    public function images()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\Images', 'PropID', 'ID');
    }
    
    public function lateArrivalFees()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\LateArrivalFees', 'PropID', 'ID');
    }
    
    public function location()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Locations', 'DetailedLocationID', 'LocationID');
    }
    
    public function minStays()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\MinStays', 'PropID', 'ID');
    }
    
    public function owner()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\Owners', 'OwnerID', 'OwnerID');
    }
    
    public function payementMethods()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\PaymentMethods', 'PropID', 'ID');
    }
    
    public function pickupServices()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\PickupServices', 'PropID', 'ID');
    }
    
    public function propType()
    {
        return $this->belongsTo('Jasekz\RentalsUnitedCaching\Models\PropTypes', 'PropertyTypeID', 'PropertyTypeID');
    }
    
    public function seasonPrices()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\SeasonPrices', 'PropID', 'ID');
    }

    public function additionalFees()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\PropAdditionalFees', 'PropID', 'ID')->orderBy('Order', 'ASC')->orderBy('DiscriminatorID', 'ASC');
    }

    /**
     * @return string
     */
    public function getFullAddress(){
        return $this->Street . ' ' . 
               $this->location->Location . ' ' .
               $this->location->parentLocation->Location . ' ' .
               $this->ZipCode . ' ' .
               $this->location->parentLocation->parentLocation->Location;
    }

    /**
     * @return float
     */
    public function getSpaceInFeet(){
        // multiply by 10.764 to convert m^2 to ft^2
        return $this->Space * 10.764;
    }

    /**
     * Get additional fees base amount
     * 
     * WARNING: this function currently does not handle all types 
     *  of Rentals United additional fees
     * 
     * @return float
     */
    public function getAdditionalFeeBaseAmount($optionalFeeIds=[], $numNights=0, $numGuests=0){
        $newPrice = $this->CleaningPrice;

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !in_array($fee->ID, $optionalFeeIds)){
                continue;
            }

            switch($fee->DiscriminatorID){
                case 1:
                    $newPrice += $fee->Value;
                    break;
                case 2:
                    $newPrice += $fee->Value * $numNights;
                    break;
                default:
                    // not handled
                    break;
            }
        }

        return round($newPrice, 2);
    }

    /**
     * Get additional fees base amount
     * 
     * WARNING: this function currently does not handle all types 
     *  of Rentals United additional fees
     * 
     * @return float
     */
    public function getAdditionalFeeTaxedAmount($optionalFeeIds=[], $numNights=0, $numGuests=0){
        $newPrice = 0;
        $newPrice = $this->CleaningPrice;

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !in_array($fee->ID, $optionalFeeIds)){
                continue;
            }

            switch($fee->DiscriminatorID){
                case 1:
                    $newPrice += $fee->Value;
                    break;
                case 2:
                    $newPrice += $fee->Value * $numNights;
                    break;
                case 3:
                case 4:
                    $newPrice *= (1 + $fee->Value);
                    break;
                case 5:
                    $newPrice += ($numGuests * $fee->Value);
                    break;
                default:
                    // not handled
                    break;
            }
        }

        return round($newPrice, 2);
    }

    /**
     * Add independent tax fees to provided price
     * 
     * WARNING: this function currently does not handle all types 
     *  of Rentals United additional fees
     * 
     * @return float
     */
    public function getTaxedBaseAmount($basePrice, $optionalFeeIds=[]){
        $newPrice = $basePrice;

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !in_array($fee->ID, $optionalFeeIds)){
                continue;
            }

            switch($fee->DiscriminatorID){
                case 3:
                case 4:
                    $newPrice *= (1 + $fee->Value);
                    break;
                default:
                    // not handled
                    break;
            }
        }

        return round($newPrice, 2);
    }

    /**
     * Add required fees and taxes to provided price
     * 
     * WARNING: this function currently does not handle all types 
     *  of Rentals United additional fees
     * 
     * @return float
     */
    public function getTotalPrice($basePrice, $optionalFeeIds=[], $numNights=0, $numGuests=0){
        $newPrice = $basePrice;
        $newPrice += $this->CleaningPrice;

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !in_array($fee->ID, $optionalFeeIds)){
                continue;
            }

            switch($fee->DiscriminatorID){
                case 1:
                    $newPrice += $fee->Value;
                    break;
                case 2:
                    $newPrice += $fee->Value * $numNights;
                    break;
                case 3:
                case 4:
                    $newPrice *= (1 + $fee->Value);
                    break;
                case 5:
                    $newPrice += ($numGuests * $fee->Value);
                    break;
                default:
                    // not handled
                    break;
            }
        }

        return round($newPrice, 2);
    }

    /**
     * @return float
     */
    function getRUPrice($basePrice){
        $newPrice = $basePrice;
        $newPrice += $this->CleaningPrice;

        foreach($this->additionalFees as $fee){
            // Optional fees don't seem to be included in the RUPrice
            if($fee->Optional){
                continue;
            }

            // tax
            switch($fee->DiscriminatorID){
                case 1:
                    $newPrice += $fee->Value;
                    break;
                case 3:
                case 4:
                    $newPrice *= (1 + $fee->Value);
                    break;
                case 5:
                    $newPrice += ($numGuests * $fee->Value);
                    break;
                default:
                    // not handled
                    break;
            }
        }

        return round($newPrice, 2);
    }
}