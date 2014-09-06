<?php
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST','localhost:3306');
DEFINE('DB_DATABASE','receipt_db');

//build connection
$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

//test connection
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

$sql = array("CREATE TABLE receipt(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
name CHAR(30), 
date_stamp date,
value FLOAT(10),
description CHAR(30),
type VARCHAR (255),
purchaser VARCHAR(255)
	)",
"CREATE TABLE alt_response(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	receipt_name CHAR(30) NOT NULL REFERENCES receipt(name),
	type CHAR(30),
	response VARCHAR(255))"
	); 

	foreach ($sql as $stmt) {
		if (mysqli_query($con, $stmt)){
			echo "Table created successfully. \n";
		}else{
			echo "Error executing: " . $stmt . "\nError produced: " . mysqli_error($con) . "\n";
		}
	}


//cut connection
mysqli_close($con);

?>