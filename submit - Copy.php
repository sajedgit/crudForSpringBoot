<?php

include("aaa.php");

$db_name="test";
$user="root";
$pass="";

// Make a MySQL Connection
mysql_connect("localhost", $user, $pass) or die(mysql_error());
mysql_select_db($db_name) or die(mysql_error());

$query=$_POST["query"];

// Create a MySQL table in the selected database
$result=mysql_query($query);
if($result<1)
{
	echo "<br/>Error in table structure ";
	die();
}


$query_for_list_table="show tables from $db_name";		// find the table in the selected database
$result_for_list_table=mysql_query($query_for_list_table);

if (!$result_for_list_table) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    die();
}
$arr=array();
while ($tables = mysql_fetch_row($result_for_list_table)) 
{
    //echo "Table: {$row[0]}\n";
	
	$table_name=$tables[0];
	$query_for_column="DESCRIBE  $table_name";		// find the column name from selected table
	$result_for_table_column=mysql_query($query_for_column);

	if (!$result_for_table_column) 
	{
	echo "DB Error, could not list columns\n";
	echo 'MySQL Error: ' . mysql_error();
	die();
	}

	while ($columns = mysql_fetch_row($result_for_table_column)) 
	{
	//print_r($columns);
	array_push($arr, $columns);
	
	}
	echo "###<br/>";
	
}

print_r($arr);




function get_column($table_name)
{
	
	//echo "Table---->: $table_name\n";
	


}


function create_model($table_name)
{
	
	$file = fopen("$table_name.php","w");
	$file_data=get_file_data($table_name);
 fwrite($file,$file_data);
fclose($file);
}













?>