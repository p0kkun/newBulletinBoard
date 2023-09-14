<?php
$pdo=new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 
'hoteluser', 'password');
foreach ($pdo->query('select * from Customers') as $row) {
	echo '<p>';
	echo $row['customer_id'], ':';
	echo $row['first_name'],' ';
	echo $row['last_name'],':';
    echo $row['email'], ':';
	echo $row['phone_number'];
	echo '</p>';
}
?>