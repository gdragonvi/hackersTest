<?php
$mysql_hostname = '192.168.56.105';
$mysql_username = 'develop';
$mysql_password = 'localhost';
$mysql_database = 'hackers';
$mysql_port = '3306';

$connect = mysqli_connect($mysql_hostname,$mysql_username,$mysql_password,$mysql_database);

mysqli_select_db($connect,$mysql_database) or die("DB선택 실패");



/*$sql = "select * from member";

$rs = mysqli_query($connect,$sql);
$rs = mysqli_fetch_array($rs);
print_r($rs);*/




?>