<?php

	$db = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=password');

	$dailybreakdown = array();
	$topfoods       = array();
	$topshops       = array();
	$items          = array();
	$shops          = array();

	if(isset($_GET['cid']) && is_numeric($_GET['cid'])) {
		$referencedItems = '';
		$referencedShops = '';

		// Daily breakdown query

		// TODO: Implement

		// Top foods query 

		$topFoodsQuery = pg_query($db, 'SELECT purchases.itemid, COUNT(purchases.itemid) AS quantity, COUNT(purchases.itemid) * items.price AS total FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE purchases.cid = ' . $_GET['cid'] . ' GROUP BY purchases.itemid, items.price;');
		while($topFood = pg_fetch_object($topFoodsQuery)) {
			array_push($topfoods, $topFood);
			$referencedItems = $referencedItems . $topFood->itemid . ',';
		}

		// Top shops query

		// TODO: Implement

		$referencedItems = substr($referencedItems, 0, max(0, strlen($referencedItems) - 1));
		$referencedShops = substr($referencedShops, 0, max(0, strlen($referencedShops) - 1));

		// Add in referenced items

		$refItemQuery = pg_query($db, 'SELECT * FROM items WHERE itemid IN (' . $referencedItems . ');');
		while($refItem = pg_fetch_object($refItemQuery)) {
			array_push($items, $refItem);
		}

		// Add in referenced shops

		$refShopQuery = pg_query($db, 'SELECT * FROM shops WHERE shopid IN (' . $referencedShops . ');');
		while($refShop = pg_fetch_object($refShopQuery)) {
			array_push($shops, $refShop);
		}
	}

	$result = array();
	$result['dailybreakdown'] = $dailybreakdown;
	$result['topfoods'] = $topfoods;
	$result['topshops'] = $topshops;
	$result['items'] = $items;
	$result['shops'] = $shops;

	echo json_encode($result);

	pg_close($db);

?>
