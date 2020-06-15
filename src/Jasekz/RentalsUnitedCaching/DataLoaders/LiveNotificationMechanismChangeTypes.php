<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class LiveNotificationMechanismChangeTypes extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListLiveNotificationMechanismChangeTypes';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_LiveNotificationMechanismChangeTypes';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'LiveNotificationMechanismChangeTypes.xml';

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
            
            foreach ($this->getFileContents($this->fileName)->ChangeTypes->ChangeType as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set ChangeTypeID=?, 
                            Description=?, 
                            ExampleUrl=?,
                            created_at=?;";

                DB::statement($sql, array(
                    (string) $record->attributes()->ID,
                    (string) $record->Description,
                    (string) $record->ExampleUrl,
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