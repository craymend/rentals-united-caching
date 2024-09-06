<?php
namespace Jasekz\RentalsUnitedCaching\Models;

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

    public function requiredAdditionalFees()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\PropAdditionalFees', 'PropID', 'ID')->where('Optional', 0)->orderBy('DiscriminatorID', 'ASC');
    }

    public function optionalAdditionalFees()
    {
        return $this->hasMany('Jasekz\RentalsUnitedCaching\Models\PropAdditionalFees', 'PropID', 'ID')->where('Optional', 1)->orderBy('DiscriminatorID', 'ASC');
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
        return $this->Space * 10.764; // multiply by 10.764 to convert m^2 to ft^2
    }

    /**
     * Add required fees and taxes to provided price.
     * 
     * This value is required for the "ClientPrice" property when inserting a new reservation 
     *   using the "PutConfirmedReservationMulti" method.
     * 
     * "Final price for the guest."
     * https://developer.rentalsunited.com/#put-confirmed-reservations
     * 
     * @param float $basePrice
     * @param Illuminate\Support\Collection $optionalFees
     * @param int $numNights
     * @param int $numGuests
     * @return float
     */
    public function getTotalPrice($basePrice, $optionalFees, $numNights=0, $numGuests=0){
        // NOTE: on 2023-06-28, RentalsUnited removed the CleaningPrice from the property properties, 
        //   but some properties still have it set. Supposedly it will be moved
        //   to the "additionalFees" property and the old CleaningPrice will be set to 0 so this 
        //   should still work correctly.
        $basePrice += $this->CleaningPrice;

        $newPrice = $basePrice;

        $optionalFeeIds = $optionalFees->pluck('fee_id');

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !$optionalFeeIds->contains($fee->ID)){
                continue;
            }

            $usage = null;
            
            if($fee->Optional){
                $curOptionalFee = $optionalFees->where('fee_id', $fee->ID)->first();
                $usage = $curOptionalFee['usage'];
            }

            $prevAdditionalFees = $this->additionalFees->where('Order', '<', $fee->Order);

            $newPrice += $fee->getFeeAmount($basePrice, $prevAdditionalFees, $numNights, $numGuests, $usage);
        }

        return round($newPrice, 2);
    }

    /**
     * This value is required for the "RUPrice" property when inserting a new reservation 
     *   using the "PutConfirmedReservationMulti" method.
     * 
     * "The price returned by one of the RU methods for the property in the specified dates."
     * https://developer.rentalsunited.com/#put-confirmed-reservations
     * 
     * @param float $basePrice
     * @param Illuminate\Support\Collection $optionalFees
     * @param int $numNights
     * @param int $numGuests
     * @return float
     */
    public function getRUPrice($basePrice, $numNights=0, $numGuests=0){
        // NOTE: on 2023-06-28, RentalsUnited removed the CleaningPrice from the property properties, 
        //   but some properties still have it set. Supposedly it will be moved
        //   to the "additionalFees" property and the old CleaningPrice will be set to 0 so this 
        //   should still work correctly.
        $basePrice += $this->CleaningPrice;

        $newPrice = $basePrice;

        foreach($this->additionalFees as $fee){
            // Optional fees don't seem to be included in the RUPrice
            if($fee->Optional){
                continue;
            }

            $prevAdditionalFees = $this->additionalFees->where('Order', '<', $fee->Order);

            $newPrice += $fee->getFeeAmount($basePrice, $prevAdditionalFees, $numNights, $numGuests);
        }

        return round($newPrice, 2);
    }

    /**
     * Get list of additional fees.
     * 
     * @param float $basePrice
     * @param Illuminate\Support\Collection $optionalFees
     * @param int $numNights
     * @param int $numGuests
     * @return array
     */
    public function getAdditionalFeesList($basePrice, $optionalFees, $numNights=0, $numGuests=0){
        $fees = [];
        $taxTypeIds = AdditionalFeeTypes::getTaxTypeIds();

        $optionalFeeIds = $optionalFees->pluck('fee_id');

        // NOTE: on 2023-06-28, RentalsUnited removed the CleaningPrice from the property properties, 
        //   but some properties still have it set. Supposedly it will be moved
        //   to the "additionalFees" property and the old CleaningPrice will be set to 0 so this 
        //   should still work correctly.
        if($this->CleaningPrice > 0){
            $fees[] = [
                'name' => 'Cleaning fee',
                'amount' => $this->CleaningPrice
            ];
        }

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !$optionalFeeIds->contains($fee->ID)){
                continue;
            }else if(in_array($fee->FeeTaxType, $taxTypeIds)){
                continue;
            }

            $usage = null;
            
            if($fee->Optional){
                $curOptionalFee = $optionalFees->where('fee_id', $fee->ID)->first();
                $usage = $curOptionalFee['usage'];
            }

            $prevAdditionalFees = $this->additionalFees->where('Order', '<', $fee->Order);

            $fees[] = [
                'name' => $fee->Name,
                'amount' => $fee->getFeeAmount($basePrice, $prevAdditionalFees, $numNights, $numGuests, $usage)
            ];
        }

        return $fees;
    }

    /**
     * Get list of additional taxes.
     * 
     * @param float $basePrice
     * @param Illuminate\Support\Collection $optionalFees
     * @param int $numNights
     * @param int $numGuests
     * @return array
     */
    public function getAdditionalTaxesList($basePrice, $optionalFees, $numNights=0, $numGuests=0){
        $fees = [];
        $taxTypeIds = AdditionalFeeTypes::getTaxTypeIds();

        $optionalFeeIds = $optionalFees->pluck('fee_id');

        foreach($this->additionalFees as $fee){
            if($fee->Optional && !$optionalFeeIds->contains($fee->ID)){
                continue;
            }else if(!in_array($fee->FeeTaxType, $taxTypeIds)){
                continue;
            }

            $usage = null;
            
            if($fee->Optional){
                $curOptionalFee = $optionalFees->where('fee_id', $fee->ID)->first();
                $usage = $curOptionalFee['usage'];
            }

            $prevAdditionalFees = $this->additionalFees->where('Order', '<', $fee->Order);

            $fees[] = [
                'name' => $fee->Name,
                'amount' => $fee->getFeeAmount($basePrice, $prevAdditionalFees, $numNights, $numGuests, $usage),
                'basePrice' => $basePrice,
            ];
        }

        return $fees;
    }
}