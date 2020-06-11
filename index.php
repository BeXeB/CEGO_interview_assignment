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
  $sql = "SELECT id, firstName, lastName, email FROM users WHERE firstName LIKE 'A%'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $filename = 'test' . '.csv';

  $data = fopen($filename, 'a');
  $datarows = 0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	  $datarows++;
      fputcsv($data, $row);
  }
  fclose($data);
  
  if (file_exists($filename)) {
    $filerows = 0;
    $fp = fopen("test.csv","r");
    if($fp){
      while(!feof($fp)){
        $content = fgets($fp);
        if($content)    $filerows++;
      }
    }
    fclose($fp);
	if($datarows === $filerows){
	  $sql = "DELETE FROM users WHERE firstName LIKE 'A%'";
	  $conn->exec($sql);
	  echo "record(s) deleted";
	}else{
		echo "file incomplete";
	}
  }else {
	echo "file doesn't exist";
  }
  
} catch(PDOException $e) {
  echo $e->getMessage();
}

?> 

</body>
</html>