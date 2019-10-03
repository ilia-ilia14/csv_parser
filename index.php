<?php //php 7.0.8



if(!empty($_GET['csvstring'])) {
	$string = $_GET['csvstring'];
	$csvs = processCsv($string);
	
	foreach($csvs as $csv) {
			echo $csv . "<br/>";
	}
	
	//return json file
	//deliver_response(200,"success",$csvs);
} else {
	deliver_response(400,"Request is not valid",NULL);
}

/******************************
 * Processes string and converts it to CSV
 *****************************/
function processCsv($string) {
	// replaces spaces and charactes, also replaces newlines
	$string = str_replace('" "', '"_"', $string);
	$string = str_replace('""', '"_"', $string);
	$string = str_replace(array("\r\n", "\r", "\n"), '_', $string);
	$csvArray = [];
	
	// convert string into array and separate CSV's
	$textArray = explode("_", $string);
	//print_r($textArray);
	// get each CSV value and create an array
	foreach($textArray as $txt) {
		$txt[0] = '[';
		$txt[strlen($txt)] = ']';
		$txt = str_replace(array('","', '",', ',"',), '] [', $txt);
		$txt = str_replace('"', '', $txt);
		array_push($csvArray, $txt);
	}
	//print_r($csvArray);
	return $csvArray;
}

/******************************
 * Delivers the response
 *****************************/
function deliver_response($status,$status_message,$data) {
header("HTTP/1.1 $status $status_message") ;
 
$response['status_code'] = $status;
$response['status_message'] = $status_message;
$response['result']=$data;
 
$json_response = json_encode($response);
echo $json_response;
}

?>