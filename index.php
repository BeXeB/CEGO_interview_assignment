<!DOCTYPE html>
<html>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cego";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $conn->prepare("SELECT * FROM users");
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  
  $myfile = fopen("file.txt", "w");
  
  foreach($stmt->fetchAll() as $k => $v){
	  foreach($v as $k => $a){
		  $txt = $a . ",\t";
		  fwrite($myfile, $txt);
	  }
	  fwrite($myfile, "\n");
  }
  
} catch(PDOException $e) {
  echo $e->getMessage();
}

?> 

</body>
</html>