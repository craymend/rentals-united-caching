<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class ReservationStatuses extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListReservationStatuses';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_ReservationStatuses';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'ReservationStatuses.xml';

    /**
     * Cache RU data to DB
     *
     * @throws Exception
     * @return void
     */
    public function cacheInDb()
    {
        $this->downloadXML($this->fileName);
        
        try {
            DB::statement("truncate {$this->table}");
            
            foreach ($this->getFileContents($this->fileName)->ReservationStatuses->ReservationStatus as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set ReservationStatusID=?, 
                            ReservationStatus=?,
                            created_at=?;";
                DB::statement($sql, array(
                    (string) $record->attributes()->ReservationStatusID,
                    (string) $record,
                    date('Y-m-d H:i:s')
                ));
            }
            
            $this->deleteXML($this->fileName);
        } 

        catch (Exception $e) {
            throw $e;
        }
    }
}