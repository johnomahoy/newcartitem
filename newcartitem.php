<?php
//Test Connection
require_once("isdk.php");	
$app = new iSDK;

if( $app->cfgCon("kf342")){ 
	$websiteUserID = $_REQUEST['WebsiteUserId']; 
	$itemimageURL = $_REQUEST['itemimageURL'];	
	$itemTitle = $_REQUEST['itemTitle'];
	$email = $_REQUEST['email'];
	
	//Get account ID	
	$returnFields = array('Id');
	$contacts = $app->dsFind('Contact',1,0,'_websiteUserID',$websiteUserID,$returnFields);
 	 
	foreach($contacts as $contact=>$key){
		foreach($key as $results){
			$contact_id = $results; 
		}
	}
	
	//fetch the old data from the field
	$returnFields = array('_itemTitle');
	$conDat = $app->dsLoad("Contact",$contact_id, $returnFields);
	$itemtitle1 = $conDat;
	
	//fetch the old data from the field
	$returnFields = array('_itemimageURL');
	$conDat = $app->dsLoad("Contact",$contact_id, $returnFields);
	$itemurl1 = $conDat;

	//----> Loop the new data.
	$counter = 1;
	$counter2 = 1; 
	foreach($itemimageURL as $itemimageURL){
		 $imageurl[$counter] = $itemimageURL;
		 $counter++;
	}
	 
	//----> Loop the new data.
	foreach($itemTitle as $itemTitle){
		 $title[$counter2] = $itemTitle;
		 $counter2++;
	}
	/*
	//Merge the two array the new data and the old data that we fetch
	$temp = array_merge($itemtitle1,$title);
	$temp1 = array_merge($itemurl1,$imageurl);*/
	
	/*
	//Transfer the data 
	$result = implode(',',$temp);
	$result1 = implode(',',$temp1);*/
	 
	$grp = array('_itemTitle'  => $title,
	'_itemimageURL'  => $imageurl);
	
	$grpID = $app->dsUpdate("Contact", $contact_id, $grp);
	
	//Check if the process is complete 
	echo $grpID;
	
	
	//Funnel Goal
	$Integration = 'kf342';
	$callName = 'newcartitem';
 
	$app->achieveGoal($Integration, $callName, $contact_id);  
}  
?>