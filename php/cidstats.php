<?php

	/**
	
		FILENAME: cidstats.php
		AUTHOR:   Peregrine park
		DATE:     26.02.2012
		PRPJECT:  Imperial College Hackathon 2012
	
	**/

	function statsForCid($db, $cid, $days)
	{
		$dailybreakdown = array();
		$topfoods       = array();
		$topshops       = array();
		$items          = array();
		$shops          = array();

		$dayTimestampValue  = 24 * 60 * 60;

		$numberOfdays = isset($days) && is_numeric($days) ? $days : 7;
		$lowestTimestamp = $numberOfdays * $dayTimestampValue;

		if(isset($cid) && is_numeric($cid)) {
			$referencedItems = '';
			$referencedShops = '';

			$nextDayM1Timestamp = mktime(23, 59, 59);

			// Daily breakdown query
			for($i = 1; $i <= $numberOfdays; $i++) {
				$updayselect = $nextDayM1Timestamp - ($i - 1) * $dayTimestampValue;
				$lodayselect = $nextDayM1Timestamp -  $i      * $dayTimestampValue;

				$dailyBreakdownQuery = pg_query($db, 'SELECT COUNT(*) AS count, SUM(items.price) AS total FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE timestamp >= ' . $lodayselect . ' AND timestamp <= ' . $updayselect . ' AND cid = ' . $cid . ';');
				$dayBreakdown = pg_fetch_object($dailyBreakdownQuery);

				$dayBreakdown->day = date('l', (($lodayselect + $updayselect) / 2));
				if($dayBreakdown->total == null) {
					$dayBreakdown->total = 0;
				}

				array_push($dailybreakdown, $dayBreakdown);
			}

			// Top foods query
			$topFoodsQuery = pg_query($db, 'SELECT purchases.itemid, COUNT(purchases.itemid) AS quantity, COUNT(purchases.itemid) * items.price AS total FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE purchases.timestamp >= ' . $lowestTimestamp . ' AND purchases.cid = ' . $cid . ' GROUP BY purchases.itemid, items.price;');
			while($topFood = pg_fetch_object($topFoodsQuery)) {
				$topFood->itemid   = intval($topFood->itemid);
				$topFood->quantity = intval($topFood->quantity);
				$topFood->total    = intval($topFood->total);

				array_push($topfoods, $topFood);

				$referencedItems = $referencedItems . $topFood->itemid . ',';
			}

			// Top shops query
			$topShopsQuery = pg_query($db, 'SELECT purchases.shopid, COUNT(purchases.itemid), COUNT(purchases.itemid) * (SELECT price FROM items WHERE itemid = purchases.itemid) AS total FROM purchases WHERE purchases.timestamp >= ' . $lowestTimestamp . ' AND purchases.cid = ' . $cid . ' GROUP BY purchases.shopid, purchases.itemid;');
			while($topShop = pg_fetch_object($topShopsQuery)) {
				$topShop->shopid = intval($topShop->shopid);
				$topShop->count  = intval($topShop->count);
				$topShop->total  = intval($topShop->total);

				array_push($topshops, $topShop);

				$referencedShops = $referencedShops . $topShop->shopid . ',';
			}

			// Strip the last ','s if there are some
			$referencedItems = substr($referencedItems, 0, max(0, strlen($referencedItems) - 1));
			$referencedShops = substr($referencedShops, 0, max(0, strlen($referencedShops) - 1));

			// Add in referenced items
			$refItemQuery = pg_query($db, 'SELECT * FROM items WHERE itemid IN (' . $referencedItems . ');');
			while($refItem = pg_fetch_object($refItemQuery)) {
				$refItem->itemid = intval($refItem->itemid);
				$refItem->price  = intval($refItem->price);

				array_push($items, $refItem);
			}

			// Add in referenced shops
			$refShopQuery = pg_query($db, 'SELECT * FROM shops WHERE shopid IN (' . $referencedShops . ');');
			while($refShop = pg_fetch_object($refShopQuery)) {
				$refShop->shopid = intval($refShop->shopid);

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
	}

?>
