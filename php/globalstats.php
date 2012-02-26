<?php

	/**
	
		FILENAME: globalstats.php
		AUTHOR:   Peregrine Park and Dario Mheliocchetti
		DATE:     26.02.2012
		PROJECT:  Imperial College Hackathon 2012
	
	**/

	function globalStats($db, $days, $subset, $max)
	{
		$data     = array();
		$topItems = array();
		$topShops = array();

		$time = mktime(23, 59, 59) - $days * 24 * 60 * 60;

		if($subset == 'all' || $subset == 'items') {
			$topItemsQuery = pg_query($db, 'SELECT purchases.itemid, COUNT(purchases.itemid) AS count, SUM(purchases.itemid * items.price) AS sales, items.name FROM purchases INNER JOIN items ON purchases.itemid = items.itemid WHERE purchases.timestamp >= ' . $time . ' GROUP BY purchases.itemid, items.name ORDER BY sales DESC LIMIT ' . $max . ';');

			while($topItem = pg_fetch_object($topItemsQuery)) {
				$topItem->itemid = intval($topItem->itemid);
				$topItem->count  = intval($topItem->count);
				$topItem->sales  = intval($topItem->sales);
	
				array_push($topItems, $topItem);
			}
		}

		if($subset == 'all' || $subset == 'shops') {
			$topShopsQuery = pg_query($db, 'SELECT purchases.shopid, COUNT(purchases.itemid) AS count, SUM(purchases.itemid * items.price) AS sales, shops.name FROM purchases INNER JOIN items ON purchases.itemid = items.itemid INNER JOIN shops ON purchases.shopid = shops.shopid WHERE purchases.timestamp >= ' . $time . ' GROUP BY purchases.shopid, shops.name ORDER BY sales DESC LIMIT ' . $max . ';');

			while($topShop = pg_fetch_object($topShopsQuery)) {
				$topShop->shopid = intval($topShop->shopid);
				$topShop->count  = intval($topShop->count);
				$topShop->sales  = intval($topShop->sales);
	
				array_push($topShops, $topShop);
			}
		}

		$data['topItems'] = $topItems;
		$data['topshops'] = $topShops;

		echo json_encode($data);
	}

?>
