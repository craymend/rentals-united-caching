<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class PropertyPrices extends Base {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListPropertyPrices';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_PropertyPrices';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'PropertyPrices.xml';

    /**
     * Cache RU data to DB
     *
     * @throws Exception
     * @return void
     */
    public function cacheInDb($propertyId = null)
    {
        $this->cacheStandardPricing($propertyId);
        $this->cacheFspPricing($propertyId);
    }

    /**
     *  Cache standard/length of stay (LOS) pricing
     * 
     * @throws Exception
     * @return void
     */
    public function cacheStandardPricing($propertyId = null){
        $fileName = 'PropertyID_' . $propertyId . '_' . $this->fileName;

        $dateFrom = date('Y-m-d');
        $dateTo = date('Y-m-d', strtotime('+1 year'));
        $pricingModelMode = 0; // standard/length of stay (LOS) pricing
        
        $this->downloadXML($fileName, $propertyId, $dateFrom, $dateTo, $pricingModelMode);
        
        try {
            DB::statement("delete from {$this->table} where PropID=?", array(
                $propertyId
            ));
            DB::statement("delete from RentalsUnited_PropertyPricesLOS where PropID=?", array(
                $propertyId
            ));
            DB::statement("delete from RentalsUnited_PropertyPricesLOSP where PropID=?", array(
                $propertyId
            ));
            DB::statement("delete from RentalsUnited_PropertyPricesEGP where PropID=?", array(
                $propertyId
            ));
            
            foreach ($this->getFileContents($fileName)->Prices->Season as $record) {
                $sql = "insert into 
                        {$this->table} 
                        set PropID=?, 
                            SeasonDateFrom=?,
                            SeasonDateTo=?,
                            SeasonPrice=?,
                            SeasonExtra=?,
                            created_at=?;";
                DB::statement($sql, array(
                    $propertyId,
                    (string) $record->attributes()->DateFrom,
                    (string) $record->attributes()->DateTo,
                    (string) $record->Price,
                    (string) $record->Extra,
                    date('Y-m-d H:i:s')
                ));
                
                $propertyPricesID = DB::connection()->getPdo()->lastInsertId();
                
                if( isset($record->LOSS->LOS)) {
                    foreach ($record->LOSS->LOS as $los) {
                        
                        $sql = "insert into 
                                RentalsUnited_PropertyPricesLOS
                                set PropID=?, 
                                    PropertyPricesID=?,
                                    Nights=?,
                                    Price=?,
                                    created_at=?;";
                        DB::statement($sql, array(
                            $propertyId,
                            $propertyPricesID,
                            (string) $los->attributes()->Nights,
                            (string) $los->Price,
                            date('Y-m-d H:i:s')
                        ));
                
                        $propertyPricesLOSID = DB::connection()->getPdo()->lastInsertId();
                
                        if( isset($los->LOSPS->LOSP)) {
                            foreach ($los->LOSPS->LOSP as $losp) {

                                $sql = "insert into 
                                        RentalsUnited_PropertyPricesLOSP
                                        set PropID=?, 
                                            PropertyPricesID=?,
                                            PropertyPricesLOSID=?,
                                            NrOfGuests=?,
                                            Price=?,
                                            created_at=?;";
                                DB::statement($sql, array(
                                    $propertyId,
                                    $propertyPricesID,
                                    $propertyPricesLOSID,
                                    (string) $losp->attributes()->NrOfGuests,
                                    (string) $losp->Price,
                                    date('Y-m-d H:i:s')
                                ));
                            }
                        }
                    }
                }
                
                if( isset($record->EGPS->EGP)) {
                    foreach ($record->EGPS->EGP as $egp) {
                        
                        $sql = "insert into 
                                RentalsUnited_PropertyPricesEGP
                                set PropID=?, 
                                    PropertyPricesID=?,
                                    ExtraGuests=?,
                                    Price=?,
                                    created_at=?;";
                        DB::statement($sql, array(
                            $propertyId,
                            $propertyPricesID,
                            (string) $egp->attributes()->ExtraGuests,
                            (string) $egp->Price,
                            date('Y-m-d H:i:s')
                        ));
                    }
                }
            }
            
            $this->deleteXML($fileName);
        } 

        catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Cache full stay pricing (FSP)
     * 
     * @throws Exception
     * @return void
     */
    public function cacheFspPricing($propertyId = null){
        $fileName = 'PropertyID_' . $propertyId . '_' . $this->fileName;

        $dateFrom = date('Y-m-d');
        $dateTo = date('Y-m-d', strtotime('+1 year'));
        $pricingModelMode = 1; // standard/length of stay (LOS) pricing
        
        $this->downloadXML($fileName, $propertyId, $dateFrom, $dateTo, $pricingModelMode);
        
        try {
            DB::statement("delete from RentalsUnited_PropertyFSPPrices where PropID=?", array(
                $propertyId
            ));
            
            foreach ($this->getFileContents($fileName)->Prices->FSPSeasons->FSPSeason as $fspSeason) {
                $fspDate = $fspSeason->attributes()->Date;
                $defaultPrice = $fspSeason->attributes()->DefaultPrice;

                foreach ($fspSeason->FSPRows->FSPRow as $fspRow) {
                    $nrOfGuests = $fspRow->attributes()->NrOfGuests;

                    foreach ($fspRow->Prices->Price as $price) {
                        $sql = "insert into 
                                    RentalsUnited_PropertyFSPPrices 
                                set PropID=?,
                                    FSPSeasonDate=?,
                                    FSPSeasonDefaultPrice=?,
                                    NrOfGuests=?,
                                    NrOfNights=?,
                                    Price=?,
                                    created_at=?;";

                        DB::statement($sql, array(
                            $propertyId,
                            (string) $fspDate,
                            (string) $defaultPrice,
                            (string) $nrOfGuests,
                            (string) $price->attributes()->NrOfNights,
                            (string) $price,
                            date('Y-m-d H:i:s')
                        ));
                    }
                }
            }
            
            $this->deleteXML($fileName);
        } 

        catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Download and store XML file from RU
     * Each service can override this function and provde the RU service that should be called, if needed
     *
     * @param
     *            mixed Argument to pass on to RU
     * @throws Exception
     * @return void
     */
    public function downloadXML($fileName, $propertyId = null, $dateFrom = null, $dateTo = null, $pricingModelMode=0)
    {
        try {
            $xml = $this->ru->{$this->ruFunction}($propertyId, $dateFrom, $dateTo, $pricingModelMode);
            
            $obj = simplexml_load_string($xml['messages']);
            
            if ((string) $obj->Status != 'Success') {
                throw new Exception('Error downloading xml file.');
            }

            echo "FileName (downloadXML): {$fileName}\r\n";

            if($obj->ResponseID){
                echo "ResponseID: {$obj->ResponseID}\r\n";
            }
            
            $h = fopen($this->getCacheDir() . $fileName, 'w');
            fwrite($h, $xml['messages']);
            fclose($h);
        } 

        catch (Exception $e) {
            throw $e;
        }
    }
}