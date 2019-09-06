<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


session_cache_expire(60*30);
session_start();
if(empty($_SESSION['id'])) {
	$_SESSION['attempt'] = 1;
	$_SESSION['id'] = rand();
}
else {
	$_SESSION['attempt']++;
}

$counter = 1;
$StringForDB;
$ID_IBLOCK = 8;


if($decoded = json_decode($_POST['info'],true)) {
	$StringForDB .= $_SESSION['attempt'] . ": user: " . $_SESSION['id'] . " IP : " . $_SERVER['REMOTE_ADDR']. "\n";
	if(is_array($decoded)) {
		foreach ($decoded as $key => $value) {
			$StringForDB .= $counter. ") " . $key;			   
			foreach($decoded[$key] as $key2 => $value2) {
					$StringForDB .= ": \"" . $value2 . "\"";			     
			}
			$counter++;
			$StringForDB .=  " \n";
		} 
	}
	$StringForDB .=  " \n";
	file_put_contents('userinfo.log',$StringForDB,FILE_APPEND);
}

if(CModule::IncludeModule("iblock") )   {
	if($_POST['submitted']) {  
		$PROPERTY_VAL = array();
		$PROPERTY_VAL['ID'] = $_SESSION['id'];
		$PROPERTY_VAL['ATTEMPT'] = $_SESSION['attempt'];
		$PROPERTY_VAL['IP'] = $_SERVER['REMOTE_ADDR'];
		$PROPERTY_VAL['DATA'] = $StringForDB;

		$array = new CIBlockElement;
		$array->Add(array(
			"MODIFIED_BY" => $USER->GetID(),
			"IBLOCK_ID" => $ID_IBLOCK,
			"PROPERTY_VALUES" => $PROPERTY_VAL,
			"NAME" => "element"
		));
	}		

	$GettingList = CIBlockElement::GetList(
		Array("TIMESTAMP_X" =>"DESC"),
		Array("IBLOCK_ID" => $ID_IBLOCK),
		false,
		false,
		Array("ID","PROPERTY_SESSION","PROPERTY_ATTEMPT","PROPERTY_IP","PROPERTY_DATA","NAME")
	);

	while($ob = $GettingList->GetNextElement()) {
		echo "<pre>";
		 print_r($ob);
		echo "</pre>";
	}
 } 	
?>