<?php

include 'koneksi.php';
 
$con = mysqli_connect($server, $user_name, $password, $db_name);
if($con)
{
	$query = "SELECT * FROM tb_kabkota";

	$result = mysqli_query($con, $query);

	$rows = array();
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r;
	}
}
else { $status = 'DATABASE CONNECTION FAILED'; }

echo '{"results":'.json_encode($rows).'}';

mysqli_close($con);
?>