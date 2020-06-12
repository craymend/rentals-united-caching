<?php
namespace Jasekz\RentalsUnitedCaching\DataLoaders;

use DB;
use Exception;

class Languages extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'ListLanguages';

    /**
     * DB table where we'll be caching the data
     *
     * @var string
     */
    protected $table = 'RentalsUnited_Languages';

    /**
     * Cached file name
     *
     * @var string
     */
    protected $fileName = 'Languages.xml';

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
            
            foreach ($this->getFileContents($this->fileName)->Languages->Language as $record) {

                $sql = "insert into 
                        {$this->table} 
                        set LanguageID=?, 
                            LanguageCode=?, 
                            Language=?,
                            created_at=?;";
                DB::statement($sql, array(
                    (string) $record->attributes()->LanguageID,
                    (string) $record->attributes()->LanguageCode,
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