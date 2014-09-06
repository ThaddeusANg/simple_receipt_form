<?php

	// select.php Script to execute from index.php to view the contents of test_db.Apprentices

	DEFINE('DB_USERNAME', 'root');
	DEFINE('DB_PASSWORD', 'root');
	DEFINE('DB_HOST', 'localhost');
	DEFINE('DB_DATABASE','receipt_db');

	//Create connection
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

$sql = "SELECT * FROM receipt";

		if ($result = mysqli_query($con,$sql))
		{
			echo "<table border='1'><tr>";
			$nameArray = array();
			while($finfo = mysqli_fetch_field($result)){
				$colName = $finfo->name;
				array_push($nameArray, $colName);
				printf("<th>".$colName."</th>");
			}
			echo "</tr>";
		}
		else{
			echo "Error contacting database: ".mysqli_error($con);
		}

	$result = mysqli_query($con, "SELECT * FROM receipt");	

	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		for($x=0; $x<count($nameArray); $x++){
			$currentContent = $row[$nameArray[$x]];
			echo "<td>".$currentContent."</td>";

		}
		echo "</tr>";
	}

	echo "</table>";

	$totalSql = "SELECT SUM(value) AS Total_Spent FROM receipt GROUP BY purchaser";
	$total = mysqli_query($con, $totalSql);
	
	$userNum = 1;
	while($row = mysqli_fetch_array($total)){
		echo "User ". $userNum."'s total is: $".$row['Total_Spent'] ;
		$userNum ++;
		echo "</br>";
	}
	

	mysqli_close($con);

?>

