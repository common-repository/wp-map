<?php



class AgileMaps_Helper {


	public static function getLnt($_address) {

		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_address)."&sensor=false";

		$crl = curl_init();
		
		curl_setopt($crl, CURLOPT_URL, $url );                                                               
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);             
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, 0);                
		
		$result = curl_exec($crl);
		curl_close($crl);
		$result = json_decode($result);
		

		if(isset($result->results[0])) {

			$result1=$result->results[0];

			$result1 = array(
				'address'=> $result1->formatted_address,
				'lat' => $result1->geometry->location->lat,
				'lng' => $result1->geometry->location->lng
			);
			return $result1;
		}
		else
			return array();
	}

	public static function getaddress($lat,$lng) {

		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")
		return $data->results[0]->formatted_address;
		else
		return false;
	}

	public static function getCoordinates($street,$city,$state,$zip,$country)
	{
		$params = array(
			'address' => $street,'city'=> $city, 'state'=> $state,'postcode'=> $zip, 'country' => $country
		);

		if($params['postcode'] && $params['city'] && $params['state']) {

			$_address = $params['address'].', '.$params['postcode'].'  '.$params['city'].' '.$params['state'].' '.$params['country'];
			$response = self::getLnt($_address);
			
			if($response['address'] && $response['lng'] && $response['lat']) {
				
				return $response;
			}
			else {
				return null;
			}
		}
		else
		{
			return null;
		}
		
		return true;
	}
}

?>
