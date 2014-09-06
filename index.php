<html>
 <head><title>PHP Test</title></head>
 <body>
 <?php echo '<p>Hello World</p>'; ?> 
<form action="insert.php" method="post">

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

		$sql = "SELECT * FROM receipt";

		if ($result = mysqli_query($con,$sql))
		{
			$intId=0;
			while($finfo = mysqli_fetch_field($result)){
				$colName = $finfo->name;
				$colType = $finfo->type;
				if($intId==0){
					$intId=1;
				}else{
					echo $colName.": ";
					if($colType==254 || $colType==4){
						printf("<input type ='%s' name=%s></br>", $colType, $colName);
					}else{
						$altRespSql = "SELECT * FROM alt_response WHERE receipt_name='$colName'";
						$altResp = mysqli_query($con,$altRespSql);
						while($altResult = mysqli_fetch_array($altResp)){
							$inputSwitch = $altResult['type'];
							switch($inputSwitch){
								case "date":
								printf("<input type ='%s' name=%s></br>", $colType, $colName);
								echo "yyyy-mm-dd";
								break;
								case "select":
								break;
								case "radio":
								$inputContent = $altResult['response'];
								printf("<input type ='%s' name=%s value=%s>%s", $inputSwitch, $colName, $inputContent, $inputContent);
								break;
							}
						}
						echo "</br>";
					}
					
				}
				
			}
		}
		else{
			echo "Error contacting database: ".mysqli_error($con);
		}

		//cut connection
		mysqli_close($con);
		?>
	</br><input type="submit">
</form>
	<p><a href="select.php">Click here to view table</a></p>
	<?php include 'select.php' ?> 
	<p><a href="select_target.php">Click here to view target data</a></p>
<p><a href="create_db.php">Click here to Generate Table</a></p>
<p><a href="create_table.php">Click here to view table</a></p>
 </body>

</html>