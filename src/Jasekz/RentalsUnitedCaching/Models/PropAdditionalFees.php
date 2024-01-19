<?php
namespace Jasekz\RentalsUnitedCaching\Models;

use Illuminate\Support\Facades\Log;

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

    /**
     * @param float $baseAmount
     * @param \Illuminate\Support\Collection $additionalFees the fees up to and NOT including this fee as ordered by "PropAdditionalFees.Order"
     * @param int $numNights
     * @param int $numGuests
     * 
     * @return float
     */
    public function getFeeAmount($baseAmount, $additionalFees, $numNights, $numGuests, $usage=null){
        $amount = 0;

        switch($this->DiscriminatorID){
            case 1:
                // 1 - "FlatPerStay - a fixed value will be added once per whole stay. Value=10.05 means 10.05 EUR/USD or other currency will be added as additional fee."
                $amount = $this->Value;
                break;
            case 2:
                // 2 - "FixedPerDay - a fixed value will be added for each day of stay. Value=10.05 means 10.05 EUR/USD or other currency will be added as additional fee."
                $amount = $numNights * $this->Value;
                break;
            case 3:
                // 3 - "IndependentPercentage - a percentage of total value will be added independently at the end of calculations. Value=0.0123 means 1.23% additional fee will be added."
                // NOTE: this is not well explained in the documentation but it appears the 
                //  percentage is applied to the running total of earlier applied fees (earlier being dependent on the "PropAdditionalFees.Order") AND NOT 
                //  including any earlier fees of type 3.
                $feeBaseAmont = $baseAmount;
                $prevFee = $additionalFees->last();
                if($prevFee){
                    // DiscriminatorID 3 fees are "applied independently" and are not applied to the running total
                    $prevFees = $additionalFees->where('Order', '<', $prevFee->Order)->where('DiscriminatorID', '!=', 3);
                    $feeBaseAmont = $prevFee->getFeeRunningTotal($baseAmount, $prevFees, $numNights, $numGuests);
                }
                $amount = $feeBaseAmont * (float)$this->Value;
                break;
            case 4:
                // 4 - "CumulativePercentage - a percentage of total value which will be added immediately and will take part in further calculation. Value=0.0123 means 1.23% additional fee will be added."
                $amount = $baseAmount * (float)$this->Value;
                break;
            case 5:
                // 5 - "FixedAmountPerPerson - a fixed value will be added for whole stay for each person."
                $amount = ($numGuests * (float)$this->Value);
                break;
            case 6:
            case 7:
            case 8:
                // 6 - "FixedAmountPerPersonPerDay - a fixed value will be added for each day of stay for each person."
                // 7 - "FixedAmountPerPersonPerWeek - a fixed value will be added for every week commenced, for each person."
                // 8 - "FixedAmountPerWeek - a fixed value will be added for every week commenced."
                break;
            case 9:
                // 9 - "VariableAmountByConsumption - the value of the fee depends on consumption."
                $amount = $this->Value * $usage;
                break;
            case 10:
            case 11:
            case 12:
            case 13:
            case 14:
                // 10 - "VariableAmountByUse - the value of the fee depends on use."
                // 11 - "FixedAmountPerSet - the value of the fee depends on number of sets."
                // 12 - "FixedAmountPerSetPerWeek - the value of the fee depends on number of sets, for every week commenced."
                // 13 - "IndependentPercentagePerDay - a percentage of total value for each day of stay will be added independently at the end of calculations."
                // 14 - "IndependentPercentagePerPerson - a percentage of total value for each person will be added independently at the end of calculations."
                break;
            default:
                // not handled
                break;
        }

        return $amount;
    }

    /**
     * @param number $baseAmount
     * @param \Illuminate\Support\Collection $additionalFees the fees up to and NOT including this fee as ordered by "PropAdditionalFees.Order"
     * @param number $numNights
     * @param number $numGuests
     * 
     * @return float
     */
    public function getFeeRunningTotal($baseAmount, $additionalFees, $numNights, $numGuests){
        $feeBaseAmount = (float)$baseAmount;

        $runningTotalAdditionalFees = $additionalFees->where('Order', '<', $this->Order);

        foreach($additionalFees as $fee){
            $feeBaseAmount += $fee->getFeeAmount($feeBaseAmount, $runningTotalAdditionalFees, $numNights, $numGuests);
        }

        $feeAmount = $this->getFeeAmount($baseAmount, $additionalFees, $numNights, $numGuests);

        return $feeBaseAmount + $feeAmount;
    }
}