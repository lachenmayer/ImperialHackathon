<?php

	echo 'test<br>';

	$db = new mysqli("129.31.217.212", "hackathon", "password", "hackathon");

	echo 'test<br>';

	$result = $db->query("SELECT * FROM items;");

	echo 'test<br>';

	while($row = $result->fetch_assoc()) {
		echo "" . $row['id'] . " is a " . $row['name'] . " and costs " . $row['price'] . '<br>';
	}

	echo 'test<br>';

?>
