# Rentals United Caching

[![Software License][ico-license]](LICENSE)


Synchronize [Rentals United](https://rentalsunited.com/) data with your local database.  

## Installation

NOTE: If you haven't set up a database yet for your app, please do that first as per Laravel docs -  https://laravel.com/docs/5.5/database.

Via composer.<br/>

```
composer require craymend/rentals-united-caching
```

Run 

    artisan vendor:publish
    
followed by

    artisan migrate

Now in your .env file, define your Rentals United credentials and path to store the downloaded XML files (temporary storage):
```php
RENTALS_UNITED_USERNAME=<your Rentals United username/email>
RENTALS_UNITED_PASSWORD=<your Rentals United password>
XML_CACHE_DIR='/path/to/cache/directory/'
```
## Usage Examples
- artisan **rentals_united:cache_all** 
   - Init RU data. Truncate all tables and cache everything.

- artisan **rentals_united:cache_dictionaries** 
  - Truncate all dictionary tables and cache dictionary data. 
  - RU docs recommend running this "once a month".

- artisan **rentals_united:cache_properties --id=4,5** 
  - Cache specific properties on demand by id.

- artisan **rentals_united:cache_properties --id=new** 
  - Find and cache all properties created in the last 2 hours

- artisan **rentals_united:update_change_log --since="-1 day"** 
  - Update change logs older then 'since' given date/time.
  - RU docs recommend running this "at least once a day".

- artisan **rentals_united:update_properties --since="-1 day"** 
  - Update properties data with local change log date 'since' given date/time.  
  - RU docs recommend running this "at least once a day".

- artisan **rentals_united:cache_reservations --since="-20 minute"** 
  - Cache reservations with LastMod in window 'since' given date/time to current time. Does not truncate any existing reservations.
  - RU does not allow a window larger then 7 days. 
  - RU docs recommend running this "at least every 20 minutes".

- artisan **rentals_united:cache_reservations --id=3,4** 
  - Cache specific reservations on demand by id.

## Laravel Scheduler Example
[Laravel task scheduling](https://laravel.com/docs/5.5/scheduling) makes it easy to update cached data.

Example:
```
protected  function  schedule(Schedule  $schedule)
{
  $dayStr = date('Y-m-d');

  $schedule->command('rentals_united:update_reservations --since="-21 minute"')
    ->appendOutputTo(storage_path("logs/cron-{$dayStr}.log"))
    ->cron('*/20 * * * * *');

  $schedule->command('rentals_united:cache_dictionaries')
    ->appendOutputTo(storage_path("logs/cron-{$dayStr}.log"))
    ->monthlyOn(1, '00:00');
  
  $schedule->command('rentals_united:update_change_log')
    ->appendOutputTo(storage_path("logs/cron-{$dayStr}.log"))
    ->dailyAt('00:00');
  
  $schedule->command('rentals_united:update_properties --since="-25 hour"')
    ->appendOutputTo(storage_path("logs/cron-{$dayStr}.log"))
    ->dailyAt('00:00');
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.



[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
