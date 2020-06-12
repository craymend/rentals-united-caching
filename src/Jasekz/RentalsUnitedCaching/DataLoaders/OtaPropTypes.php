<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class OtaPropTypes extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListOTAPropTypes';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_OtaPropTypes';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'OtaPropTypes.xml';

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

            foreach ($this->getFileContents($this->fileName)->PropertyTypes->PropertyType as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set PropertyTypeID=?,
                            OTACode=?,
                            PropertyType=?,
                            created_at=?;";
                DB::statement($sql, array(
                    (string) $record->attributes()->PropertyTypeID,
                    (string) $record->attributes()->OTACode,
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