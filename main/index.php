<?php

$db = new mysqli("localhost", "hackathon", "password", "hackathon");

/*


if (@$_GET['type'] == 'item' && is_numeric($_GET['id']))
{
$result = $db->query("SELECT * FROM items;");

while($row = $result->fetch_assoc()) {
	echo "ITEM ID" . $row['id'] . " is a " . $row['name'] . " and costs " . $row['price'] . '<br>';
}

*/
$daysToFetch = (is_numeric(@$_GET['latest'])) ? $_GET['latest'] : 7;

if (@$_GET['type'] == 'cid' && is_numeric($_GET['id']))
{
	$id = $db->escape_string($_GET['id']);
	$items = array();
	$locations = array();
	$rows = array();
	
	$result = $db->query("SELECT  * FROM data WHERE cid = '$id' AND date >= '". (time() - ($daysToFetch*24*60*60)) ."'");
	while($row = $result->fetch_assoc())
	{
		if (!in_array($row['itemid'], $items))
		{
			$items[] = $row['itemid'];
		}
		
		if (!in_array($row['shop'], $locations))
		{
			$locations[] = $row['shop'];
		}
		
		unset($row['cid']);
		
		$data['purchases'][] = $row;
	}
	
	$sql = "SELECT * FROM items WHERE id = '".(implode("' or id = '", $items))."'";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$data['iteminfo'][] = $row;
	}
	
	$sql = "SELECT * FROM shop WHERE id = '".(implode("' or id = '", $locations))."'";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$data['shopinfo'][] = $row;
	}
	
	echo json_encode($data);
	//print_r($items);
	//print_r($locations);
}

?>