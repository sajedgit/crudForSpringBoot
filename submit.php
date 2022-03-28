<?php

include("model.php");
include("controller.php");
include("view.php");

$db_name="cakephp2";
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

//print_r($arr[0]);die();

$table_name_to_class=create_table_to_class_name($table_name);

create_model($arr,$table_name,$table_name_to_class);
create_view($arr,$table_name,$table_name_to_class);
create_controller($arr,$table_name,$table_name_to_class);


$sql = "DROP TABLE $table_name";
$retval = mysql_query( $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
else
	echo "Table deleted successfully\n";


function create_model($arr,$table_name,$table_name_to_class)
{
	
	if (!file_exists('data/application/models')) 
	{
    mkdir('data/application/models', 0777, true);
	}

	
	$file = fopen("data/application/models/".$table_name."_model.php","w");
	$file_data=get_model_data($arr,$table_name);	//	get_model_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/application/models/common_model.php","w");
	$file_data=get_common_model_data($arr,$table_name);	//	get_common_model_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
}



function create_view($arr,$table_name,$table_name_to_class)
{
	
	if (!file_exists("data/application/views/$table_name")) 
	{
    mkdir("data/application/views/$table_name", 0777, true);
	}

	$file = fopen("data/application/views/$table_name/single_".$table_name."_view.php","w");
	$file_data=get_single_view_data($arr,$table_name,$table_name_to_class);	//	get_single_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/application/views/$table_name/edit_".$table_name."_form.php","w");
	$file_data=get_edit_view_data($arr,$table_name,$table_name_to_class);	//	get_edit_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/application/views/$table_name/all_".$table_name."_view.php","w");
	$file_data=get_all_view_data($arr,$table_name,$table_name_to_class);	//	get_all_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/application/views/$table_name/add_".$table_name."_form.php","w");
	$file_data=get_add_data($arr,$table_name,$table_name_to_class);	//	get_add_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	if (!file_exists("data/application/views/layout")) 
	{
    mkdir("data/application/views/layout", 0777, true);
	}
	
	$file = fopen("data/application/views/layout/main_layout.php","w");
	$file_data=get_main_layout_data($arr,$table_name);	//	get_main_layout_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	
	
	
}




function create_controller($arr,$table_name,$table_name_to_class)
{
	
	if (!file_exists('data/application/controllers')) 
	{
    mkdir('data/application/controllers', 0777, true);
	}

	
	$file = fopen("data/application/controllers/".$table_name_to_class.".php","w");
	$file_data=get_controller_data($arr,$table_name,$table_name_to_class);	//	get_controller_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
}



function create_table_to_class_name($table_name)
{
$new_class_name="";
$table_name_captalize=ucwords($table_name);
$table_arr=preg_split("/[-,_,#,\s]+/", $table_name_captalize);
foreach($table_arr as $data):
$new_class_name.=ucwords($data);
endforeach;

return	$new_class_name;	

}






?>