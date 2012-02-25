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
$daysToFetch = (is_numeric(@$_GET['latest'])) ? $_GET['latest'] : -1;
$topShops = (is_numeric(@$_GET['topamount'])) ? $_GET['topamount'] : 1;


if (@$_GET['type'] == "topshop" && $daysToFetch != -1) //we've given a timeframe, so we don't want global data
{
	if ($value == 0) //if we want it over all time
	{
		$sql = "SELECT COUNT(*) AS `Rows`, shop
FROM `data`
GROUP BY shop
ORDER BY `Rows` DESC
LIMIT $topShops";
	}
	else //otherwise, we have veen given a time
	{
		$sql = "SELECT COUNT(*) AS `Rows`, shop
FROM `data`
WHERE date >= '". (time() - ($daysToFetch*24*60*60)) ."'
GROUP BY shop
ORDER BY `Rows` DESC
LIMIT $topShops";
	}
	$result = $db->query($sql);
	
	while($row = $result->fetch_assoc())
	{
		$topshops[] = $row['shop'];
	}
	
	foreach ($topshops as $key=>$value)
	{
		$rows[] = $db->query("SELECT * FROM shop WHERE id = '$value'")->fetch_assoc();
	}
	echo json_encode($rows);
}
elseif (@$_GET['type'] == "topshop") //this means we want global data
{
	$daystofetch = array("7", "30", '0');
	foreach ($daystofetch as $key=>$value)
	{
		if ($value == 0)
		{
			$sql = "SELECT COUNT(*) AS `Rows`, shop
FROM `data`
GROUP BY shop
ORDER BY `Rows` DESC
LIMIT $topShops";
		}
		else
		{
			$sql = "SELECT COUNT(*) AS `Rows`, shop
FROM `data`
WHERE date >= '". (time() - ($value*24*60*60)) ."'
GROUP BY shop
ORDER BY `Rows` DESC
LIMIT $topShops";
		}
		
		$result=$db->query($sql);
		
		$value = ($value==0) ? 'all' : $value;
		
		while($row = $result->fetch_assoc())
		{
			$topshops[$value."days"][] = $row['shop'];
		}
		
		foreach ($topshops[$value."days"] as $key=>$value2)
		{
			$rows[$value."days"][] = $db->query("SELECT * FROM shop WHERE id = '$value2'")->fetch_assoc();
		}
	}
	
	echo json_encode($rows);
}









if (@$_GET['type'] == "topitem" && $daysToFetch != -1) //we've given a timeframe, so we don't want global data
{
	if ($value == 0) //if we want it over all time
	{
		$sql = "SELECT COUNT(*) AS `Rows`, itemid
FROM `data`
GROUP BY itemid
ORDER BY `Rows` DESC
LIMIT $topShops";
	}
	else //otherwise, we have veen given a time
	{
		$sql = "SELECT COUNT(*) AS `Rows`, itemid
FROM `data`
WHERE date >= '". (time() - ($daysToFetch*24*60*60)) ."'
GROUP BY itemid
ORDER BY `Rows` DESC
LIMIT $topShops";
	}
	$result = $db->query($sql);
	
	while($row = $result->fetch_assoc())
	{
		$topshops[] = $row['itemid'];
	}
	
	foreach ($topshops as $key=>$value)
	{
		$rows[] = $db->query("SELECT * FROM items WHERE id = '$value'")->fetch_assoc();
	}
	echo json_encode($rows);
}
elseif (@$_GET['type'] == "topitem") //this means we want global data
{
	$daystofetch = array("7", "30", '0');
	foreach ($daystofetch as $key=>$value)
	{
		if ($value == 0)
		{
			$sql = "SELECT COUNT(*) AS `Rows`, itemid
FROM `data`
GROUP BY itemid
ORDER BY `Rows` DESC
LIMIT $topShops";
		}
		else
		{
			$sql = "SELECT COUNT(*) AS `Rows`, itemid
FROM `data`
WHERE date >= '". (time() - ($value*24*60*60)) ."'
GROUP BY itemid
ORDER BY `Rows` DESC
LIMIT $topShops";
		}
		
		$result=$db->query($sql);
		
		$value = ($value==0) ? 'all' : $value;
		
		while($row = $result->fetch_assoc())
		{
			$topshops[$value."days"][] = $row['itemid'];
		}
		
		foreach ($topshops[$value."days"] as $key=>$value2)
		{
			$rows[$value."days"][] = $db->query("SELECT * FROM items WHERE id = '$value2'")->fetch_assoc();
		}
	}
	
	echo json_encode($rows);
}



if (@$_GET['type'] == 'mostprofit' && is_numeric($_GET['id']))




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