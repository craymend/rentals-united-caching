<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsUnitedTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->upDictionaryTables();
        $this->upStaticPropertyTables();
        $this->upAvailablityAndPriceTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->downDictionaryTables();
        $this->downStaticPropertyTables();
        $this->downAvailablityAndPriceTables();
    }

    private function upAvailablityAndPriceTables()
    {
        Schema::create('RentalsUnited_PropertyBlocks', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyAvailabilityCalendar', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('Date');
            $table->integer('Units');
            $table->integer('Reservations');
            $table->integer('IsBlocked');
            $table->integer('MinStay');
            $table->integer('Changeover');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyMinStay', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('MinStay');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyBasePrice', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('DayOfWeek');
            $table->float('BasePrice');
            $table->float('BasePriceExtra');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyPrices', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('SeasonDateFrom');
            $table->date('SeasonDateTo');
            $table->float('SeasonPrice');
            $table->float('SeasonExtra');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyPricesLOS', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('PropertyPricesID');
            $table->integer('Nights');
            $table->float('Price');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyPricesLOSP', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('PropertyPricesID');
            $table->integer('PropertyPricesLOSID');
            $table->integer('NrOfGuests');
            $table->float('Price');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyPricesEGP', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('PropertyPricesID');
            $table->integer('ExtraGuests');
            $table->float('Price');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyAVBPrice', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->float('PropertyPrice');
            $table->integer('NOP');
            $table->float('Cleaning');
            $table->float('ExtraPersonPrice');
            $table->float('Deposit');
            $table->float('SecurityDeposit');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyFSPPrices', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('FSPSeasonDate');
            $table->float('FSPSeasonDefaultPrice');
            $table->integer('NrOfGuests');
            $table->integer('NrOfNights');
            $table->float('Price');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyDiscountsLongStays', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->integer('Bigger');
            $table->integer('Smaller');
            $table->integer('LongStay');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyDiscountsLastMinutes', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->integer('DaysArrivalFrom');
            $table->integer('DaysArrivalTo');
            $table->integer('LastMinute');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Reservations', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('ReservationID');
            $table->integer('StatusID');
            $table->datetime('LastMod');
            $table->string('CustomerName');
            $table->string('CustomerSurName');
            $table->string('CustomerEmail');
            $table->string('CustomerPhone');
            $table->string('CustomerSkypeID');
            $table->string('CustomerAddress');
            $table->string('CustomerZipCode');
            $table->string('CustomerCountryID');
            $table->string('CustomerPassport');
            $table->string('Creator');
            $table->text('Comments');
            $table->string('CCNumber');
            $table->string('CVC');
            $table->string('NameOnCard', 400);
            $table->string('Expiration');
            $table->string('BillingAddress', 400);
            $table->string('CardType');
            $table->text('CCComments', 400);
            $table->string('PMSReservationId');
            $table->integer('CancelTypeID')->nullable();
            $table->integer('IsArchived');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_ReservationStayInfos', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('ReservationID');
            $table->integer('PropID');
            $table->string('XmlApartmentID');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->integer('NumberOfGuests');
            $table->float('CostRUPrice');
            $table->float('CostClientPrice');
            $table->float('CostAlreadyPaid');
            $table->integer('ResApaID');
            $table->string('Comments', 500);
            $table->string('MappingReservationID');
            $table->string('MappingStayID');
            $table->string('MappingHotelID');
            $table->string('MappingRoomID');
            $table->string('MappingRateID');
            $table->integer('Units');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyChangeLog', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('NLA');
            $table->integer('IsActive');
            $table->datetime('StaticData');
            $table->datetime('Pricing');
            $table->datetime('Availability');
            $table->datetime('Image');
            $table->datetime('Description');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyPriceChanges', function (Blueprint $table) // NOT IMPLEMENTED
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('Day');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyAvbChanges', function (Blueprint $table) // NOT IMPLEMENTED
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('Day');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropLeads', function (Blueprint $table) // NOT IMPLEMENTED
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('ReservationID');
            $table->string('ExternalLeadID');
            $table->date('DateFrom');
            $table->date('DateTo');
            $table->integer('NumberOfGuests');
            $table->string('CustomerName');
            $table->string('CustomerSurName');
            $table->string('CustomerEmail');
            $table->string('CustomerPhone');
            $table->string('CustonmerSkypeID');
            $table->string('CustomerAddress');
            $table->string('CustomerZipCode');
            $table->integer('CustomerCountryID');
            $table->text('Comments');
            $table->string('Creator');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropChangeoverDays', function (Blueprint $table) // NOT IMPLEMENTED
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->date('StartDate');
            $table->date('EndDate');
            $table->string('Changeover');
            $table->timestamps();
        });
    }

    private function downAvailablityAndPriceTables()
    {
        Schema::drop('RentalsUnited_PropertyBlocks');
        Schema::drop('RentalsUnited_PropertyAvailabilityCalendar');
        Schema::drop('RentalsUnited_PropertyMinStay');
        Schema::drop('RentalsUnited_PropertyBasePrice');
        Schema::drop('RentalsUnited_PropertyPrices');
        Schema::drop('RentalsUnited_PropertyPricesLOS');
        Schema::drop('RentalsUnited_PropertyPricesLOSP');
        Schema::drop('RentalsUnited_PropertyPricesEGP');
        Schema::drop('RentalsUnited_PropertyAVBPrice');
        Schema::drop('RentalsUnited_PropertyFSPPrices');
        Schema::drop('RentalsUnited_PropertyDiscountsLongStays');
        Schema::drop('RentalsUnited_PropertyDiscountsLastMinutes');
        Schema::drop('RentalsUnited_Reservations');
        Schema::drop('RentalsUnited_ReservationStayInfos');
        Schema::drop('RentalsUnited_PropertyChangeLog');
        Schema::drop('RentalsUnited_PropertyPriceChanges');
        Schema::drop('RentalsUnited_PropertyAvbChanges');
        Schema::drop('RentalsUnited_PropLeads');
        Schema::drop('RentalsUnited_PropChangeoverDays');
    }

    private function upStaticPropertyTables()
    {
        Schema::create('RentalsUnited_Prop', function (Blueprint $table)
        {    
            $table->primary('ID');
            $table->integer('ID');
            $table->integer('PUID')->nullable();
            $table->string('Name');
            $table->integer('BuildingID')->nullable();
            $table->string('BuildingName')->nullable();
            $table->integer('OwnerID');
            $table->integer('DetailedLocationID');
            $table->integer('LocationTypeID')->nullable();
            $table->datetime('LastMod');
            $table->integer('LastModNLA')->nullable();
            $table->integer('IMAP')->nullable();
            $table->date('DateCreated');
            $table->float('CleaningPrice')->nullable();
            $table->integer('Space')->nullable();
            $table->integer('StandardGuests')->nullable();
            $table->integer('CanSleepMax')->nullable();
            $table->integer('PropertyTypeID')->nullable();
            $table->integer('ObjectTypeID')->nullable();
            $table->integer('NoOfUnits')->nullable();
            $table->integer('Floor')->nullable();
            $table->string('Street')->nullable();
            $table->string('ZipCode')->nullable();
            $table->string('Latitude')->nullable();
            $table->string('Longitude')->nullable();
            $table->integer('IsActive')->nullable();
            $table->integer('IsArchived')->nullable();
            $table->float('SecurityDeposit')->nullable();
            $table->string('IMU')->nullable();
            $table->string('CheckInFrom')->nullable();
            $table->string('CheckInTo')->nullable();
            $table->string('CheckOutUntil')->nullable();
            $table->string('Place')->nullable();
            $table->integer('DepositTypeID')->nullable();
            $table->float('Deposit')->nullable();
            $table->integer('PreparationTimeBeforeArrival')->nullable();
            $table->integer('NumberOfStars')->nullable();
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropDistances', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('DestinationID');
            $table->integer('DistanceUnitID');
            $table->float('DistanceValue');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropCompositionRooms', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('CompositionRoomID');
            $table->integer('Count');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropCompositionRoomAmenities', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('CompositionRoomID');
            $table->integer('AmenityID');
            $table->integer('Count');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropAmenities', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('AmenityID');
            $table->integer('Count');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropImages', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('ImageTypeID');
            $table->string('Image');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropArrivalInstructions', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('Landlord');
            $table->string('Email');
            $table->string('Phone');
            $table->integer('DaysBeforeArrival');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropLicenceInfo', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('LicenceNumber');
            $table->date('IssueDate')->nullable();
            $table->date('ExpirationDate')->nullable();
            $table->integer('IsExempt')->nullable();
            $table->integer('IsVATRegistered')->nullable();
            $table->string('ExemptionReason')->nullable();
            $table->integer('IsManagedByOwner')->nullable();
            $table->integer('IsManagedByPrivatePerson')->nullable();
            $table->string('BrazilianCityHallInfoId')->nullable();
            $table->string('JapaneseLicenceInfo')->nullable();
            $table->integer('FrenchIsRegisteredAtTradeCommercialRegister')->nullable();
            $table->string('FrenchPropertyTypeForTaxPurposes')->nullable();
            $table->integer('FrenchDeclaresRevenuesAsProfessionalForDirectTaxPurposes')->nullable();
            $table->integer('FrenchTypeOfResidence')->nullable();
            $table->integer('FrenchCityTaxCategory')->nullable();
            $table->string('TasmanianLicenceInfoTypeOfResidence')->nullable();
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropHowToArriveText', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('LanguageID');
            $table->text('Text');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropPickupServiceText', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('LanguageID');
            $table->text('Text');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropLateArrivalFees', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('From');
            $table->string('To');
            $table->float('LateArrivalFee');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropEarlyDepartureFees', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('From');
            $table->string('To');
            $table->float('EarlyDepartureFee');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropPaymentMethods', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('PaymentMethodID');
            $table->string('PaymentMethod');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropCancellationPolicies', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('ValidFrom');
            $table->integer('ValidTo');
            $table->float('CancellationPolicy');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropDescriptions', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('LanguageID');
            $table->text('Text');
            $table->string('Image');
            $table->timestamps();
        });
        
        Schema::create('RentalsUnited_Buildings', function (Blueprint $table)
        {
            $table->primary('BuildingID');
            $table->integer('BuildingID');
            $table->string('BuildingName');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_BuildingProperties', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('BuildingsID');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Owners', function (Blueprint $table)
        {
            $table->primary('OwnerID');
            $table->integer('OwnerID');
            $table->string('FirstName');
            $table->string('SurName');
            $table->string('Email');
            $table->string('Phone');
            $table->string('ScreenName')->nullable();
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Agents', function (Blueprint $table)
        {
            $table->primary('AgentID');
            $table->integer('AgentID');
            $table->string('UserName');
            $table->string('CompanyName');
            $table->string('FirstName');
            $table->string('SurName');
            $table->string('Email');
            $table->string('Telephone');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_OwnerAgents', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('OwnerID');
            $table->integer('AgentID');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyExternalListings', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('Url');
            $table->integer('Status');
            $table->text('Description');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyExternalListingsNotifs', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->string('Notif');
            $table->integer('StatusID');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyReviews', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('ReviewID');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('DisplayName');
            $table->string('Email');
            $table->integer('Rating');
            $table->date('ArrivalDate');
            $table->date('Submitted');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropertyReviewsText', function (Blueprint $table)
        {            
            $table->increments('ID');
            $table->integer('PropID');
            $table->integer('ReviewID');
            $table->integer('LanguageID');
            $table->text('Text');
            $table->timestamps();
        });
    }

    private function downStaticPropertyTables()
    {
        Schema::drop('RentalsUnited_Prop');
        Schema::drop('RentalsUnited_PropDistances');
        Schema::drop('RentalsUnited_PropCompositionRooms');
        Schema::drop('RentalsUnited_PropCompositionRoomAmenities');
        Schema::drop('RentalsUnited_PropAmenities');
        Schema::drop('RentalsUnited_PropImages');
        Schema::drop('RentalsUnited_PropArrivalInstructions');
        Schema::drop('RentalsUnited_PropLicenceInfo');
        Schema::drop('RentalsUnited_PropHowToArriveText');
        Schema::drop('RentalsUnited_PropPickupServiceText');
        Schema::drop('RentalsUnited_PropLateArrivalFees');
        Schema::drop('RentalsUnited_PropEarlyDepartureFees');
        Schema::drop('RentalsUnited_PropPaymentMethods');
        Schema::drop('RentalsUnited_PropCancellationPolicies');
        Schema::drop('RentalsUnited_PropDescriptions');
        
        Schema::drop('RentalsUnited_Buildings');
        Schema::drop('RentalsUnited_BuildingProperties');
        Schema::drop('RentalsUnited_Owners');
        Schema::drop('RentalsUnited_Agents');
        Schema::drop('RentalsUnited_OwnerAgents');
        Schema::drop('RentalsUnited_PropertyExternalListings');
        Schema::drop('RentalsUnited_PropertyExternalListingsNotifs');
        Schema::drop('RentalsUnited_PropertyReviews');
        Schema::drop('RentalsUnited_PropertyReviewsText');
    }

    private function upDictionaryTables()
    {        
        Schema::create('RentalsUnited_Statuses', function (Blueprint $table)
        {
            $table->primary('ID');
            $table->integer('ID');
            $table->string('Status');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropTypes', function (Blueprint $table)
        {
            $table->primary('PropertyTypeID');
            $table->integer('PropertyTypeID');
            $table->string('PropertyType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_OTAPropTypes', function (Blueprint $table)
        {
            $table->primary('PropertyTypeID');
            $table->integer('PropertyTypeID');
            $table->string('OTACode');
            $table->string('PropertyType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_LocationTypes', function (Blueprint $table)
        {
            $table->primary('LocationTypeID');
            $table->integer('LocationTypeID');
            $table->string('LocationType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Locations', function (Blueprint $table)
        {
            $table->primary('LocationID');
            $table->integer('LocationID');
            $table->integer('LocationTypeID');
            $table->integer('ParentLocationID');
            $table->string('Location');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Cities', function (Blueprint $table)
        {
            $table->primary('LocationID');
            $table->integer('LocationID');
            $table->string('CityProps');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Currencies', function (Blueprint $table)
        {
            $table->increments('ID');
            $table->string('CurrencyCode');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_CityCurrencies', function (Blueprint $table)
        {
            $table->increments('ID');
            $table->integer('CurrencyID');
            $table->string('CityID');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Destinations', function (Blueprint $table)
        {
            $table->primary('DestinationID');
            $table->integer('DestinationID');
            $table->string('Destination', 2048);
            $table->timestamps();
        });
        Schema::create('RentalsUnited_DistanceUnits', function (Blueprint $table)
        {
            $table->primary('DistanceUnitID');
            $table->integer('DistanceUnitID');
            $table->string('DistanceUnit');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_CompositionRooms', function (Blueprint $table)
        {
            $table->primary('CompositionRoomID');
            $table->integer('CompositionRoomID');
            $table->string('CompositionRoom');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Amenities', function (Blueprint $table)
        {
            $table->primary('AmenityID');
            $table->integer('AmenityID');
            $table->string('Amenity');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_RoomAmenities', function (Blueprint $table)
        {
            $table->primary(['AmenityID', 'CompositionRoomID']);
            $table->integer('AmenityID');
            $table->string('CompositionRoomID');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_ImageTypes', function (Blueprint $table)
        {
            $table->primary('ImageTypeID');
            $table->integer('ImageTypeID');
            $table->string('ImageType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PaymentMethods', function (Blueprint $table)
        {
            $table->primary('PaymentMethodID');
            $table->integer('PaymentMethodID');
            $table->string('PaymentMethod');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_ReservationStatuses', function (Blueprint $table)
        {
            $table->primary('ReservationStatusID');
            $table->integer('ReservationStatusID');
            $table->string('ReservationStatus');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_DepositTypes', function (Blueprint $table)
        {
            $table->primary('DepositTypeID');
            $table->integer('DepositTypeID');
            $table->string('DepositType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_Languages', function (Blueprint $table)
        {
            $table->primary('LanguageID');
            $table->integer('LanguageID');
            $table->string('LanguageCode');
            $table->string('Language');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_PropExternalStatuses', function (Blueprint $table)
        {
            $table->primary('ID');
            $table->integer('ID');
            $table->string('Status');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_ChangeoverTypes', function (Blueprint $table)
        {
            $table->primary('ChangeoverTypeID');
            $table->integer('ChangeOverTypeID');
            $table->string('ChangeOverType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_AdditionalFeeKinds', function (Blueprint $table)
        {
            $table->primary('ID');
            $table->integer('ID');
            $table->string('AdditionalFeeKindInfo');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_AdditionalFeeDiscriminators', function (Blueprint $table)
        {
            $table->primary('ID');
            $table->integer('ID');
            $table->string('AdditionalFeeDiscriminatorInfo');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_AdditionalFeeTypes', function (Blueprint $table)
        {
            $table->primary('ID');
            $table->integer('ID');
            $table->string('AdditionalFeeTypeInfo');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_CancellationTypes', function (Blueprint $table)
        {
            $table->primary('Id');
            $table->integer('Id');
            $table->string('CancellationType');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_QuoteModes', function (Blueprint $table)
        {
            $table->primary('Id');
            $table->integer('Id');
            $table->string('QuoteMode');
            $table->timestamps();
        });
        Schema::create('RentalsUnited_LiveNotificationMechanismChangeTypes', function (Blueprint $table)
        {
            $table->increments('Id');
            $table->string('ChangeTypeID');
            $table->string('Description', 2000);
            $table->string('ExampleUrl', 2000);
            $table->timestamps();
        });
    }

    private function downDictionaryTables()
    {
        Schema::drop('RentalsUnited_Statuses');
        Schema::drop('RentalsUnited_OTAPropTypes');
        Schema::drop('RentalsUnited_PropTypes');
        Schema::drop('RentalsUnited_LocationTypes');
        Schema::drop('RentalsUnited_Locations');
        Schema::drop('RentalsUnited_Cities');
        Schema::drop('RentalsUnited_Currencies');
        Schema::drop('RentalsUnited_CityCurrencies');
        Schema::drop('RentalsUnited_Destinations');
        Schema::drop('RentalsUnited_DistanceUnits');
        Schema::drop('RentalsUnited_CompositionRooms');
        Schema::drop('RentalsUnited_Amenities');
        Schema::drop('RentalsUnited_RoomAmenities');
        Schema::drop('RentalsUnited_ImageTypes');
        Schema::drop('RentalsUnited_PaymentMethods');
        Schema::drop('RentalsUnited_ReservationStatuses');
        Schema::drop('RentalsUnited_DepositTypes');
        Schema::drop('RentalsUnited_Languages');
        Schema::drop('RentalsUnited_PropExternalStatuses');
        Schema::drop('RentalsUnited_ChangeoverTypes');
        Schema::drop('RentalsUnited_AdditionalFeeKinds');
        Schema::drop('RentalsUnited_AdditionalFeeDiscriminators');
        Schema::drop('RentalsUnited_AdditionalFeeTypes');
        Schema::drop('RentalsUnited_CancellationTypes');
        Schema::drop('RentalsUnited_QuoteModes');
        Schema::drop('RentalsUnited_LiveNotificationMechanismChangeTypes');
    }
}
