<?php

	$db = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=password');

	$dailybreakdown = array();
	$topfoods       = array();
	$topshops       = array();
	$items          = array();
	$shops          = array();

	$numberOfDays = isset($_GET['days']) && is_numeric($_GET['days']) ? $_GET['days'] : 7;

	if(isset($_GET['cid']) && is_numeric($_GET['cid'])) {
		$referencedItems = '';
		$referencedShops = '';

		$nextDayM1Timestamp = mktime(23, 59, 59);

		// Daily breakdown query
		for($i = 1; $i <= $numberOfDays; $i++) {
			$updayselect = $nextDayM1Timestamp - (($i - 1) * 24 * 60 * 60);
			$lodayselect = $nextDayM1Timestamp - ($i * 24 * 60 * 60);

			$dailyBreakdownQuery = pg_query($db, 'SELECT COUNT(*) AS count, SUM(items.price) AS total FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE timestamp >= ' . $lodayselect . ' AND timestamp <= ' . $updayselect . ' AND cid = ' . $_GET['cid'] . ';');
			while($dayBreakdown = pg_fetch_object($dailyBreakdownQuery)) {
				$dayBreakdown->day = 'i dunno';
				if($dayBreakdown->total == null) {
					$dayBreakdown->total = 0;
				}
				array_push($dailybreakdown, $dayBreakdown);
			}
		}

		// Top foods query
		$topFoodsQuery = pg_query($db, 'SELECT purchases.itemid, COUNT(purchases.itemid) AS quantity, COUNT(purchases.itemid) * items.price AS total FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE purchases.cid = ' . $_GET['cid'] . ' GROUP BY purchases.itemid, items.price;');
		while($topFood = pg_fetch_object($topFoodsQuery)) {
			array_push($topfoods, $topFood);
			$referencedItems = $referencedItems . $topFood->itemid . ',';
		}

		// Top shops query
		$topShopsQuery = pg_query($db, 'SELECT purchases.shopid, COUNT(purchases.itemid), COUNT(purchases.itemid) * (SELECT price FROM items WHERE itemid = purchases.itemid) AS total FROM purchases WHERE purchases.cid = ' . $_GET['cid'] . ' GROUP BY purchases.shopid, purchases.itemid;');
		while($topShop = pg_fetch_object($topShopsQuery)) {
			array_push($topshops, $topShop);
			$referencedShops = $referencedShops . $topShop->shopid . ',';
		}

		// Strip the last ','s if there are some
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
