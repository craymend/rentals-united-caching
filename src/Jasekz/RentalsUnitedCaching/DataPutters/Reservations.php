<?php
namespace Jasekz\RentalsUnitedCaching\DataPutters;

use Exception;

class Reservations extends Base  {

    /**
     * RU API function to call
     *
     * @var string
     */
    protected $ruFunction = 'PutConfirmedReservationMulti';

    /**
     * Do Rentals United PutConfirmedReservationMulti API call
     *
     * @throws Exception
     * @return void
     */
    public function bookProperty(
        $pid, $from_date, $to_date, $num_guests,
        $ru_price, $client_price, $already_paid,
        $name, $sur_name,
        $email, $phone, $address, $zipcode="",
        $skype_id="", $comments=""
    ){
        $ret = [
            'status' => '',
            'error' => '',
            'ResponseID' => '',
            'ReservationID' => ''
        ];
        
        try{
            $xml = $this->ru->{$this->ruFunction}(
                $pid, $from_date, $to_date, $num_guests,
                $ru_price, $client_price, $already_paid,
                $name, $sur_name,
                $email, $phone, $address, $zipcode,
                $skype_id, $comments
            );
            
            $obj = simplexml_load_string($xml['messages']);

            if ((string) $obj->Status != 'Success') {
                $ret['status'] = 'fail';
                $ret['error'] = (string)$obj->Status;
            }else{
                $ret['status'] = 'success';
                $ret['ResponseID'] = (string)$obj->ResponseID;
                $ret['ReservationID'] = (string)$obj->ReservationID;
            }

            return $ret;
        }catch(Exception $e){
            $ret['status'] = 'fail';
            $ret['error'] = $e->getMessage();

            return $ret;
        }
    }
}