<?php

namespace Jasekz\RentalsUnitedCaching\Lib;
  
class RentalsUnited {  
  private $username = null;
  private $password = null;
  private $server_url = 'http://rm.rentalsunited.com/api/Handler.ashx';
  
  public function __construct($username, $password) {
      $this->username = $username;
      $this->password = $password;
  }

  /**
   * Get a list of all the location where properties are provided
   * 
   * @return SimpleXMLElement
   */
  public function __call($name, $args){
      $post[] = "<Pull_{$name}_RQ>
                  <Authentication>
                    <UserName>".$this->username."</UserName>
                    <Password>".$this->password."</Password>
                  </Authentication>
                </Pull_{$name}_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }    

  /**
   * Get properties from a specific owner from getOwners()
   * 
   * @param mixed $ownerid, owner ID
   * @return SimpleXMLElement
   */
  function ListOwnerProp($ownerid){
      $post[] = "<Pull_ListOwnerProp_RQ>
                <Authentication>
                  <UserName>".$this->username."</UserName>
                  <Password>".$this->password."</Password>
                </Authentication>
                <OwnerID>$ownerid</OwnerID>
                </Pull_ListOwnerProp_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;                  
  } 

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyBasePrice($pid){
      $post[] = "<Pull_ListPropertyBasePrice_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
            </Pull_ListPropertyBasePrice_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }   

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListSpecProp($pid){
      $post[] = "<Pull_ListSpecProp_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
            </Pull_ListSpecProp_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }      

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropByCreationDate($from, $to, $includeNLA = false){
      $post[] = "<Pull_ListPropByCreationDate_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <CreationFrom>".$from."</CreationFrom>
              <CreationTo>".$to."</CreationTo>
              <IncludeNLA>". ($includeNLA ? 'true' : 'false') ."</IncludeNLA>
            </Pull_ListPropByCreationDate_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }   

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function GetPropertyExternalListing($pid){
      $post[] = "<Pull_GetPropertyExternalListing_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <Properties>
              <PropertyID>$pid</PropertyID>
              </Properties>
            </Pull_GetPropertyExternalListing_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }     

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyDiscounts($pid){
      $post[] = "<Pull_ListPropertyDiscounts_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
            </Pull_ListPropertyDiscounts_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }      

  /**
   * Get all property details based on a property ID from getPropertiesList()
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyChangeLog($pid){
      $post[] = "<Pull_ListPropertyChangeLog_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
            </Pull_ListPropertyChangeLog_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }   

  /**
   * Get property blocks
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyBlocks($pid, $dateFrom, $dateTo){
      $post[] = "<Pull_ListPropertyBlocks_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
              <DateFrom>$dateFrom</DateFrom>
              <DateTo>$dateTo</DateTo>
            </Pull_ListPropertyBlocks_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }      

  /**
   * Get property reviews
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyReviews($pid){
      $post[] = "<Pull_ListPropertyReviews_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
            </Pull_ListPropertyReviews_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }   

  /**
   * Get property availablility
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyAvailabilityCalendar($pid, $dateFrom, $dateTo){
      $post[] = "<Pull_ListPropertyAvailabilityCalendar_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
              <DateFrom>$dateFrom</DateFrom>
              <DateTo>$dateTo</DateTo>
            </Pull_ListPropertyAvailabilityCalendar_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }    

  /**
   * Get property availablility
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyMinStay($pid, $dateFrom, $dateTo){
      $post[] = "<Pull_ListPropertyMinStay_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
              <DateFrom>$dateFrom</DateFrom>
              <DateTo>$dateTo</DateTo>
            </Pull_ListPropertyMinStay_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }      

  /**
   * Get property availablility
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function GetPropertyAvbPrice($pid, $dateFrom, $dateTo){
      $post[] = "<Pull_GetPropertyAvbPrice_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
              <DateFrom>$dateFrom</DateFrom>
              <DateTo>$dateTo</DateTo>
            </Pull_GetPropertyAvbPrice_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }      

  /**
   * Get property availablility
   * 
   * @param mixed $pid, property ID
   * @return SimpleXMLElement
   */
  function ListPropertyPrices($pid, $dateFrom, $dateTo, $pricingModelMode=0){
      $post[] = "<Pull_ListPropertyPrices_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <PropertyID>$pid</PropertyID>
              <DateFrom>$dateFrom</DateFrom>
              <DateTo>$dateTo</DateTo>
              <PricingModelMode>$pricingModelMode</PricingModelMode>
            </Pull_ListPropertyPrices_RQ>";
      $x = $this->curlPushBack($this->server_url,$post);
      return $x;
  }   

  /**
   * Get reservation by id
   * 
   * @param string $id
   * @return SimpleXMLElement
   */
  function GetReservationById($id){
    $post[] = "<Pull_GetReservationByID_RQ>
                <Authentication>
                  <UserName>".$this->username."</UserName>
                  <Password>".$this->password."</Password>
                </Authentication>
                <ReservationID>" . $id . "</ReservationID>
              </Pull_GetReservationByID_RQ>";

    $x = $this->curlPushBack($this->server_url,$post);
    return $x;
  }

  /**
   * Get reservations
   * 
   * @param string $dateFrom
   * @param string $dateTo
   * @return SimpleXMLElement
   */
  function ListReservations($dateFrom, $dateTo){
    $dateFrom = $dateFrom ? $dateFrom : date('Y-m-d h:i:s');
    $dateTo = $dateTo ? $dateTo : date('Y-m-d h:i:s');

    $post[] = "<Pull_ListReservations_RQ>
            <Authentication>
              <UserName>".$this->username."</UserName>
              <Password>".$this->password."</Password>
            </Authentication>
            <DateFrom>" . $dateFrom . "</DateFrom>
            <DateTo>" . $dateTo . "</DateTo>
            <LocationID>0</LocationID>
        </Pull_ListReservations_RQ>";

    $x = $this->curlPushBack($this->server_url,$post);
    return $x;
  }

  /**
   * Make an online booking for a property, in case of success returns a reservation ID
   * 
   * @param mixed $pid, property ID
   * @param mixed $from_date, From date (yyyy-mm-dd) 
   * @param mixed $to_date, To date (yyyy-mm-dd)
   * @param mixed $pax, Number of people
   * @param mixed $ru_price, Price by Rentals United
   * @param mixed $client_price, Price offered to client
   * @param mixed $already_paid, Amount already paid
   * @param mixed $name, Name of the client
   * @param mixed $sur_name, Sur name of the client
   * @param mixed $email, Email address of the client
   * @param mixed $phone, Phone number of the client
   * @param mixed $address, Address of the client
   * @param mixed $zipcode, Zip code of the client (in case provided)
   * @param mixed $skype_id, Skype id/name (in case provided)
   * @param mixed $comments Additional comments String(4000) (in case provided)
   * @return SimpleXMLElement, reservation ID
   */
  function PutConfirmedReservationMulti(
      $pid, $from_date, $to_date, $num_guests,
      $ru_price, $client_price, $already_paid,
      $name, $sur_name,
      $email, $phone, $address, $zipcode="", $countryId="",
      $skype_id="", $comments=""
    ){
    $post[] = "<Push_PutConfirmedReservationMulti_RQ>
          <Authentication>
            <UserName>".$this->username."</UserName>
            <Password>".$this->password."</Password>
          </Authentication>
          <Reservation>
            <StayInfos>
              <StayInfo>
                <PropertyID>$pid</PropertyID>
                <DateFrom>$from_date</DateFrom>
                <DateTo>$to_date</DateTo>
                <NumberOfGuests>$num_guests</NumberOfGuests>
                <Costs>
                  <RUPrice>$ru_price</RUPrice>
                  <ClientPrice>$client_price</ClientPrice>
                  <AlreadyPaid>$already_paid</AlreadyPaid>
                </Costs>
              </StayInfo>
            </StayInfos>
            <CustomerInfo>
              <Name>$name</Name>
              <SurName>$sur_name</SurName>
              <Email>$email</Email>
              <Phone>$phone</Phone>
              <SkypeID>$skype_id</SkypeID>
              <Address>$address</Address>
              <ZipCode>$zipcode</ZipCode>
              <CountryID>$countryId</CountryID>
            </CustomerInfo>
            <Comments>$comments</Comments>
          </Reservation>
        </Push_PutConfirmedReservationMulti_RQ>";
          
    $x = $this->curlPushBack($this->server_url, $post);  
    return $x;
  }  

  /**
   * Make an online booking for a property, in case of success returns a reservation ID
   * 
   * @param mixed $pid, property ID
   * @param mixed $from, From date (yyyy-mm-dd) 
   * @param mixed $to, To date (yyyy-mm-dd)
   * @param mixed $argu, Number of available units
   * @param mixed $argms, Minimum length of stay
   * @param mixed $argc, Changeover type ID
   * @return SimpleXMLElement
   */
  function PutAvbUnits(
    $pid, $from, $to, $argu, $argms, $argc
  ){
  $post[] = "<Push_PutAvbUnits_RQ>
              <Authentication>
                <UserName>".$this->username."</UserName>
                <Password>".$this->password."</Password>
              </Authentication>
              <MuCalendar PropertyID=\"$pid\">
                <Date From=\"$from\" To=\"$to\">
                  <U>$argu</U>
                  <MS>$argms</MS>
                  <C>$argc</C>
                </Date>
              </MuCalendar>
            </Push_PutAvbUnits_RQ>";
        
  $x = $this->curlPushBack($this->server_url, $post);  
  return $x;
}  
    
  /**
   * Default Curl connection
   * 
   * @param mixed $url
   * @param mixed $post_fields
   * @param mixed $head
   * @param mixed $follow
   * @param mixed $header
   * @param mixed $referer
   * @param mixed $is_ssl
   * @param mixed $debug
   */         
  function curlPushBack($url, $post_fields = "", $head = 0, $follow = 1, $header=[], $referer="", $is_ssl = false, $debug = 0){

      $ch = curl_init ();

      $header[]="Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
      $header[]="Accept-Language: en-us";
      $header[]="Accept-Charset: SO-8859-1,utf-8;q=0.7,*;q=0.7";
      $header[]="Keep-Alive: 300";
      $header[]="Connection: keep-alive";

      curl_setopt ($ch, CURLOPT_HEADER, $head);
      curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, $follow);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.0; en; rv:1.8.0.4) Gecko/20060508 Firefox/1.5.0.4");
      curl_setopt ($ch, CURLOPT_HTTPHEADER, array
            (
                'Content-type: application/x-www-form-urlencoded; charset=utf-8',
                'Set-Cookie: ASP.NET_SessionId='.uniqid().'; path: /; HttpOnly'
            ));
      curl_setopt ($ch, CURLOPT_REFERER,$referer);
      curl_setopt ($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $is_ssl);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $is_ssl);
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

      if ($post_fields != ""){
          if(is_array($post_fields)){
            $post_fields = implode("&",$post_fields);
          }
          curl_setopt ($ch, CURLOPT_POST,1);
          curl_setopt ($ch, CURLOPT_POSTFIELDS,$post_fields);
      }

      $result=curl_exec($ch);
      $err=curl_error($ch);

      $results["messages"] = $result;
      $results["errors"] = $err;
      curl_close($ch);
      return $results;
  } 

}
