<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class AdditionalFeeDiscriminators extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListAdditionalFeeDiscriminators';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_AdditionalFeeDiscriminators';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'AdditionalFeeDiscriminators.xml';

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

            foreach ($this->getFileContents($this->fileName)->AdditionalFeeDiscriminators->AdditionalFeeDiscriminatorInfo as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set ID=?,
                            AdditionalFeeDiscriminatorInfo=?,
                            created_at=?;";
                DB::statement($sql, array(
                    (string) $record->attributes()->ID,
                    (string) $record,
                    date('Y-m-d G:i:s')
                ));
            }
            
            $this->deleteXML($this->fileName);
        } 

        catch (Exception $e) {
            throw $e;
        }
    }
}