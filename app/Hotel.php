<?php 

namespace App;
	class Hotel{
		/**
			send request to api'https://api.myjson.com/bins/tl0bp' ,
			return array of hotel data.
		**/
		public function __construct(){
			$curl = curl_init();
			// Set the url path we want to call
			curl_setopt($curl, CURLOPT_URL, 'https://api.myjson.com/bins/tl0bp');  
			// Make it so the data coming back is put into a string
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			// Send the request
			$result = curl_exec($curl);
			curl_close($curl);
			$hotelsDataFromJson = json_decode($result, true);
			$this->hotelsData = $hotelsDataFromJson['hotels'];
		}

		private static function sortByNameHotel($a, $b)
		{
			
		   return strcmp($a["name"], $b["name"]);
		}
	
		private static function sortByPriceHotel($a, $b)
		{

			 if ( floatval($a["price"]) == floatval($b["price"])) {
        		return 0;
    		}
    		return (floatval($a["price"]) < floatval($b["price"])) ? -1 : 1;
		}

		/** 
			sort array by price key.
			return array.
		**/

		public function sort($searchKey){
			$array = $this->hotelsData;
			usort($array, array($this,$searchKey));
			return $array;
		}

		/**
			search in hotel Data,
			return array.

		**/

	public function search($searchKey , $searchValue){
		$hotelsData  = $this->hotelsData;
		if($searchKey == 'name' || $searchKey === 'city'){
			$filterArray = array_filter($hotelsData, 
				function($v) use ($searchKey , $searchValue){ 
					return strpos($v[$searchKey], $searchValue) !== false ;
				});
		}elseif ($searchKey === 'to_price') {
			$searchKey = 'price';
			$from  = explode("_", $searchValue)[0];
			$to = explode("_", $searchValue)[1];
			$filterArray = array_filter($hotelsData, 
				function($v) use ($searchKey , $from , $to){ 
					return (($v[$searchKey] <= $to && $v[$searchKey] >= $from)) ;
				});
		}elseif ($searchKey === 'to_date') {
			$searchKey = 'availability';
			$from  = explode("_", $searchValue)[0];
			$to = explode("_", $searchValue)[1];
			$filterArray = array_filter($hotelsData, 
				function($v) use ($searchKey , $from , $to){ 
					foreach ($v[$searchKey] as $key => $value) {
						return (($value['to'] == $to && $value['from'] == $from)) ;
					}
					
				});
		}
		return $filterArray;
		
	}
}




?>