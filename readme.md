# Rentals United Caching

[![Software License][ico-license]](LICENSE)


Synchronize [Rentals United](http://rentalsunited.com/) data with your local database.  

## Installation

NOTE: If you haven't set up a database yet for your app, please do that first as per Laravel docs -  https://laravel.com/docs/5.5/database.

Via composer.<br/>
Add the following to your composer.json
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/craymend/rentals-united-caching.git"
    }
],
"require": {
    "jasekz/rentals-united-caching": "dev-master"
},
```
```
composer update
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
- artisan **rentals_united:cache_all** // truncate all tables and cache everything
- artisan **rentals_united:cache_dictionaries** // truncate all dictionary tables and cache dictionary data
- artisan **rentals_united:cache_properties --id=4,5** // cache properties (ID) 4 & 5
- artisan **rentals_united:cache_properties --id=new** // find and cache all new properties
- artisan **rentals_united:update_change_log --since="-1 month"** // check for updates 'since' given date/time
- artisan **rentals_united:update_properties --since="-1 month"** // update properties with changelog date 'since' given date/time
- artisan **rentals_united:cache_reservations --since="-7 days"** // cache reservations in window 'since' given date/time to current time


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.



[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
