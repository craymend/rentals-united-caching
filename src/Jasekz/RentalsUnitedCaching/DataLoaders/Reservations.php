<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB, File, Exception;
use Jasekz\RentalsUnitedCaching\Models\Reservation;

class Reservations extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListReservations';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_Reservations';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'Reservations.xml';

    /**
     * Cache RU data to DB
     *
     * @throws Exception
     * @return void
     */
    public function cacheInDb($dateFrom=null, $dateTo=null)
    {
        // default to the max allowed range
        $dateFrom = $dateFrom ? $dateFrom : date('Y-m-d H:i:s', strtotime('-7 days'));
        $dateTo = $dateTo ? $dateTo : date('Y-m-d H:i:s');

        $this->downloadXML($this->fileName, $dateFrom, $dateTo);

        try {
            foreach ($this->getFileContents($this->fileName)->Reservations->Reservation as $record) {
                $this->reservation = $record;
                $this->cacheReservation();
                $this->cacheStayInfos();
            }
            
            $this->deleteXML($this->fileName);
        } 
        catch (Exception $e) {
            throw $e;
        }
    }

    private function cacheReservation()
    {
        // check if reservation already exists
        $curResv = DB::table($this->table)
                    ->where('ReservationID', $this->reservation->ReservationID)
                    ->first();
                    
        if($curResv){
            $sql = "update 
                {$this->table} 
                set 
                    StatusID=?,
                    LastMod=?,
                    CustomerName=?,
                    CustomerSurName=?,
                    CustomerEmail=?,
                    CustomerPhone=?,
                    CustomerSkypeID=?,
                    CustomerAddress=?,
                    CustomerZipCode=?,
                    CustomerCountryID=?,
                    CustomerPassport=?,
                    Creator=?,
                    Comments=?,
                    CCNumber=?,
                    CVC=?,
                    NameOnCard=?,
                    Expiration=?,
                    BillingAddress=?,
                    CardType=?,
                    CCComments=?,
                    PMSReservationId=?,
                    CancelTypeID=?,
                    IsArchived=?,
                    updated_at=?
                where
                    id=?;";

            DB::statement($sql, array(
                (string) $this->reservation->StatusID,
                (string) $this->reservation->LastMod,
                (string) $this->reservation->CustomerInfo->Name,
                (string) $this->reservation->CustomerInfo->SurName,
                (string) $this->reservation->CustomerInfo->Email,
                (string) $this->reservation->CustomerInfo->Phone,
                (string) $this->reservation->CustomerInfo->SkypeID,
                (string) $this->reservation->CustomerInfo->Address,
                (string) $this->reservation->CustomerInfo->ZipCode,
                (string) $this->reservation->CustomerInfo->CountryID,
                (string) $this->reservation->CustomerInfo->Passport,
                (string) $this->reservation->Creator,
                (string) $this->reservation->Comments,
                (string) $this->reservation->CreditCard->CCNumber,
                (string) $this->reservation->CreditCard->CVC,
                (string) $this->reservation->CreditCard->NameOnCard,
                (string) $this->reservation->CreditCard->Expiration,
                (string) $this->reservation->CreditCard->BillingAddress,
                (string) $this->reservation->CreditCard->CardType,
                (string) $this->reservation->CreditCard->Comments,
                (string) $this->reservation->PMSReservationId,
                (string) $this->reservation->CancelTypeID ? $record->CancelTypeID : null,
                (string) $this->reservation->IsArchived ? 1 : 0,
                date('Y-m-d H:i:s'),
                $curResv->ID
            ));
        }else{
            $sql = "insert into 
                {$this->table} 
                set 
                    ReservationID=?,
                    StatusID=?,
                    LastMod=?,
                    CustomerName=?,
                    CustomerSurName=?,
                    CustomerEmail=?,
                    CustomerPhone=?,
                    CustomerSkypeID=?,
                    CustomerAddress=?,
                    CustomerZipCode=?,
                    CustomerCountryID=?,
                    CustomerPassport=?,
                    Creator=?,
                    Comments=?,
                    CCNumber=?,
                    CVC=?,
                    NameOnCard=?,
                    Expiration=?,
                    BillingAddress=?,
                    CardType=?,
                    CCComments=?,
                    PMSReservationId=?,
                    CancelTypeID=?,
                    IsArchived=?,
                    created_at=?;";

            DB::statement($sql, array(
                (string) $this->reservation->ReservationID,
                (string) $this->reservation->StatusID,
                (string) $this->reservation->LastMod,
                (string) $this->reservation->CustomerInfo->Name,
                (string) $this->reservation->CustomerInfo->SurName,
                (string) $this->reservation->CustomerInfo->Email,
                (string) $this->reservation->CustomerInfo->Phone,
                (string) $this->reservation->CustomerInfo->SkypeID,
                (string) $this->reservation->CustomerInfo->Address,
                (string) $this->reservation->CustomerInfo->ZipCode,
                (string) $this->reservation->CustomerInfo->CountryID,
                (string) $this->reservation->CustomerInfo->Passport,
                (string) $this->reservation->Creator,
                (string) $this->reservation->Comments,
                (string) $this->reservation->CreditCard->CCNumber,
                (string) $this->reservation->CreditCard->CVC,
                (string) $this->reservation->CreditCard->NameOnCard,
                (string) $this->reservation->CreditCard->Expiration,
                (string) $this->reservation->CreditCard->BillingAddress,
                (string) $this->reservation->CreditCard->CardType,
                (string) $this->reservation->CreditCard->Comments,
                (string) $this->reservation->PMSReservationId,
                (string) $this->reservation->CancelTypeID ? $record->CancelTypeID : null,
                (string) $this->reservation->IsArchived ? 1 : 0,
                date('Y-m-d H:i:s')
            ));
        }
    }

    private function cacheStayInfos(){
        $reservation = $this->reservation;

        if(!$reservation){
            // no reservation set
            return;
        }

        $sql = "delete from RentalsUnited_ReservationStayInfos where ReservationID=?;";
        DB::statement($sql, array(
            (string) $reservation->ReservationID
        ));

        if(!$reservation->StayInfos){
            // no reservation StayInfos
            return;
        }
        
        foreach($reservation->StayInfos->StayInfo as $stayInfo){
            $ruPrice = (string) $stayInfo->Costs->RUPrice;
            $ruPrice = number_format($ruPrice, 2);
            $clientPrice = (string) $stayInfo->Costs->ClientPrice;
            $clientPrice = number_format($clientPrice, 2);
            $alreadyPaid = (string) $stayInfo->Costs->AlreadyPaid;
            $alreadyPaid = number_format($alreadyPaid, 2);

            $sql = "insert into 
                        RentalsUnited_ReservationStayInfos
                    set 
                        ReservationID=?,
                        PropID=?,
                        XmlApartmentID=?,
                        DateFrom=?,
                        DateTo=?,
                        NumberOfGuests=?,
                        CostRUPrice=?,
                        CostClientPrice=?,
                        CostAlreadyPaid=?,
                        ResApaID=?,
                        Comments=?,
                        MappingReservationID=?,
                        MappingStayID=?,
                        MappingHotelID=?,
                        MappingRoomID=?,
                        MappingRateID=?,
                        Units=?,
                        created_at=?";
    
            DB::statement($sql, array(
                (string) $reservation->ReservationID,
                (string) $stayInfo->PropertyID,
                (string) $stayInfo->XmlApartmentID,
                (string) $stayInfo->DateFrom,
                (string) $stayInfo->DateTo,
                (string) $stayInfo->NumberOfGuests,
                (string) $ruPrice,
                (string) $clientPrice,
                (string) $alreadyPaid,
                (string) $stayInfo->ResapaID,
                (string) $stayInfo->Comments,
                (string) $stayInfo->MappingReservationID,
                (string) $stayInfo->MappingStayID,
                (string) $stayInfo->MappingHotelID,
                (string) $stayInfo->MappingRoomID,
                (string) $stayInfo->MappingRateID,
                (string) $stayInfo->Units,
                date('Y-m-d H:i:s')
            ));
        }
    }

    /**
     * Download and store XML file from RU
     * Each service can override this function and provde the RU service that should be called, if needed
     *
     * @param string The file name
     * @param $arg1 mixed argument to pass on to RU
     * @throws Exception
     * @return void
     */
    public function downloadXML($fileName, $dateFrom = null, $dateTo = null)
    {
        try {
            $xml = $this->ru->{$this->ruFunction}($dateFrom, $dateTo);
            
            $obj = simplexml_load_string($xml['messages']);
            
            if ((string) $obj->Status != 'Success') {
                throw new Exception('Error downloading xml file. "' . $obj . '"');
            }

            echo "FileName (downloadXML): {$fileName}\r\n";

            if($obj->ResponseID){
                echo "ResponseID: {$obj->ResponseID}\r\n";
            }
                
            // create cache dir, if it doesn't exist
            if (! File::exists($this->getCacheDir())) {
                File::makeDirectory($this->getCacheDir());
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