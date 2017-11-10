<?php 
	include("Hotel.php");
	$hotelObj = new App\Hotel(); 
	$action = $_GET['action'];
	switch ($action) {
		case 'sort':
			if($_GET['optionSelected'] == 'price'){
				$functionCall  = 'sortByPriceHotel';
				$returnData = $hotelObj->sort($functionCall);
			}
			elseif($_GET['optionSelected'] == 'name'){
				$functionCall ='sortByNameHotel';
				$returnData = $hotelObj->sort($functionCall);
			}else{
				$returnData = $hotelObj->hotelsData;
			}
			echo json_encode(array("returnData" => $returnData));
			break;
		case 'search':
			$searchKey = $_GET['searchKey'];
			$searchValue = $_GET['searchValue'];
	 		$returnData = $hotelObj->search($searchKey , $searchValue );
	 		echo json_encode(array("returnData"=>$returnData));
	 		break;
		default:
			echo "operation not handle yet";
			break;
		
	}
?>