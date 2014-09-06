<?php
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE','receipt_db');

$con = mysqli_connect(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$insertSql = "";
$startVal=0;
$sql = "SELECT * FROM receipt";
		if ($result = mysqli_query($con,$sql))
		{
			$nameArray = array();
			$insertSql = "INSERT INTO receipt (";
				while($finfo = mysqli_fetch_field($result)){
					$colName = $finfo->name;
					if($startVal==0){
						$insertSql=$insertSql."`".$colName."`";
						$startVal=1;
					}else{
						$insertSql=$insertSql.",`".$colName."`";
					}
					array_push($nameArray, $colName);
				}
			$insertSql = $insertSql.") VALUES(";
			$startVal=0;
		}
		else{
			echo "Error contacting database: ".mysqli_error($con);
		}

		for($x=0; $x<count($nameArray); $x++){
			$currentContent = $_POST[$nameArray[$x]];
			if($startVal==0){
					$insertSql=$insertSql."NULL";
					$startVal=1;
				}else{
					$insertSql=$insertSql.",'$currentContent'";
			}
		}
	
$insertSql = $insertSql.")";

if(!mysqli_query($con,$insertSql)){
	die('Error: '.mysqli_error($con));
}else{
	echo "1 record added\n";
	echo "<a href='index.php'>Click Back</a>";
}
mysql_close($con);
?>