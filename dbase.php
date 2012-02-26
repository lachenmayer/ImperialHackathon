<?php

	/**
	
		FILENAME: dbase.php
		AUTHOR:   Peregrine park
		DATE:     26.02.2012
		PROJECT:  Imperial College Hackathon 2012
	
	**/

	require 'php/cidstats.php';
	require 'php/globalstats.php';

	$db = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=password');

	// If the type is 'single' and we have a numerical College Identifier then get the stats for that ID
	if(isset($_GET['type']) && $_GET['type'] == 'single' && isset($_GET['cid']) && is_numeric($_GET['cid'])) {
		// Extract out the number of days and if it has not been requested or invalidly set then default to 7
		$days = isset($_GET['days']) && is_numeric($_GET['days']) ? $_GET['days'] : 7;
		// Extract out the CID
		$cid  = $_GET['cid'];
		// Get the stats
		statsForCid($db, $cid, $days);
	} else if(isset($_GET['type']) && $_GET['type'] == 'global') {
		// Extract out the number of days and if it has not been requested or invalidly set then default to 30
		$days = isset($_GET['days']) && is_numeric($_GET['days']) ? $_GET['days'] : 30;
		// Extract out the subset of global data to be extracted, else default to 'all'
		$subset = isset($_GET['subset']) && is_string($_GET['subset']) ? $_GET['subset'] :'all';
		// Extract out the maximum number of items to be returned, default to -1 (-> then converted to ALL)
		$max = isset($_GET['max']) && is_numeric($_GET['max']) ? $_GET['max'] : 'ALL';
		// Get the stats
		globalStats($db, $days, $subset, $max);
	} else if(isset($_GET['type']) && $_GET['type'] == 'listcid') {
		// Get a list of the college identifiers in the database
		$data = array();
		$cids = array();

		$cidsQuery = pg_query($db, 'SELECT cid FROM purchases GROUP BY cid;');

		while($cid = pg_fetch_object($cidsQuery)) {
			array_push($cids, intval($cid->cid));
		}

		$data['cids'] = $cids;
		echo json_encode($data);
	}

	pg_close($db);

?>
