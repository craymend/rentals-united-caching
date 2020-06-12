<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class CancellationTypes extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'CancellationTypes';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_CancellationTypes';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'CancellationTypes.xml';

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

            foreach ($this->getFileContents($this->fileName)->CancellationTypes->CancellationType as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set Id=?,
                            CancellationType=?,
                            created_at=?;";
                DB::statement($sql, array(
                    (string) $record->attributes()->Id,
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