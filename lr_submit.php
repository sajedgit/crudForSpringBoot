<?php
include("singularize.php");
include("model.php");
include("controller.php");
include("view.php");
include("route.php");

$db_name="crudForSpringBoot";
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

//$query_for_primary_auto_increment="ALTER TABLE `role_permission_relationships`  ADD PRIMARY KEY (`id`);
//                                   ALTER TABLE `role_permission_relationships` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;";
//$result_for_primary_auto_increment=mysql_query($query_for_primary_auto_increment);

$query_for_list_table="show tables from $db_name";		// find the table in the selected database
$result_for_list_table=mysql_query($query_for_list_table);

if (!$result_for_list_table) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    die();
}
$arr=array();
$table_list=array();
$counter=0;
while ($tables = mysql_fetch_row($result_for_list_table)) 
{
	$counter++;
    //echo "Table: {$row[0]}\n";
	//print_r($tables);die();
	$arr=array();
	$table_name=$tables[0];
	array_push($table_list, $tables[0]);
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
	print_r($columns);
	array_push($arr, $columns);
	
	}
	echo "###<br/>";
	echo "<br/>---".$table_name_to_class=create_table_to_class_name($table_name);
	echo "<br/>model_name---".$model_name=get_model_name($table_name_to_class);
	echo "<br/>controller_name---".$controller_name=get_controller_name($model_name);
	echo "<br/>repository_name---".$repository_name=get_repository_name($model_name);
	echo "<br/>constant_name---".$constant_name=get_constant_name($model_name);
	echo "<br/>request_name---".$request_name=get_request_name($model_name);
	echo "<br/>response_name---".$response_name=get_response_name($model_name);
	echo "<br/>service_name---".$response_name=get_service_name($model_name);
	echo "<br/>i_service_name---".$response_name=get_i_service_name($model_name);
	die();
	create_model($arr,$table_name,$model_name);
	create_view($arr,$table_name,$model_name);
	create_controller($arr,$table_name,$controller_name,$model_name);
	
	if($counter < 2)
	 create_route($arr,$table_name,$controller_name,$model_name);
    else 
	 create_route_multiple($arr,$table_name,$controller_name,$model_name);
	
}

//print_r($arr);echo $table_name;die();

/* foreach($table_list as $table_name):
	$table_name_to_class=create_table_to_class_name($table_name);
	$model_name=get_model_name($table_name_to_class);
	$controller_name=get_controller_name($table_name_to_class);
	create_model($arr,$table_name,$model_name);
	create_view($arr,$table_name,$model_name);
	create_controller($arr,$table_name,$controller_name);
endforeach; */


/* 
$sql = "DROP TABLE $table_name";
$retval = mysql_query( $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
else
	echo "Table deleted successfully\n"; */


function create_model($arr,$table_name,$model_name)
{
	
	if (!file_exists('data/app/Models')) 
	{
    mkdir('data/app/Models', 0777, true);
	}

	
	$file = fopen("data/app/Models/".$model_name.".php","w");
	$file_data=get_model_data($arr,$table_name,$model_name);	//	get_model_data function are in include page
	fwrite($file,$file_data);
	fclose($file);

}



function create_view($arr,$table_name,$model_name)
{
	
	if (!file_exists("data/resources/views/$model_name")) 
	{
    mkdir("data/resources/views/$model_name", 0777, true);
	}

	$file = fopen("data/resources/views/$model_name/view.blade.php","w");
	$file_data=get_single_view_data($arr,$table_name,$model_name);	//	get_single_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/resources/views/$model_name/edit.blade.php","w");
	$file_data=get_edit_view_data($arr,$table_name,$model_name);	//	get_edit_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/resources/views/$model_name/index.blade.php","w");
	$file_data=get_all_view_data($arr,$table_name,$model_name);	//	get_all_view_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	
	$file = fopen("data/resources/views/$model_name/create.blade.php","w");
	$file_data=get_add_data($arr,$table_name,$model_name);	//	get_add_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
	

	
}


function create_route($arr,$table_name,$controller_name,$model_name)
{
 
 if (!file_exists('data/routes')) 
	{
    mkdir('data/routes/', 0777, true);
	}
	
	$file = fopen("data/routes/web.php","w");
	$file_data=get_route_data($arr,$table_name,$controller_name,$model_name);	
	fwrite($file,$file_data);
	fclose($file);
		
}


function create_route_multiple($arr,$table_name,$controller_name,$model_name)
{

	$file = fopen("data/routes/web.php","a+");
	$file_data=get_route_data_multiple($arr,$table_name,$controller_name,$model_name);	
	fwrite($file,$file_data);
	fclose($file);
		
}


function create_controller($arr,$table_name,$controller_name,$model_name)
{
	
	if (!file_exists('data/app/Http/Controllers')) 
	{
    mkdir('data/app/Http/Controllers', 0777, true);
	}

	
	$file = fopen("data/app/Http/Controllers/".$controller_name.".php","w");
	$file_data=get_controller_data($arr,$table_name,$controller_name,$model_name);	//	get_controller_data function are in include page
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



function get_model_name($table_name)
{
	return singularize($table_name);	
}

function get_controller_name($table_name)
{
 
	return	$table_name."Controller";	
}



function get_repository_name($table_name)
{

	return	$table_name."Repository";
}



function get_constant_name($table_name)
{

	return	$table_name."Constant";
}



function get_request_name($table_name)
{

	return	$table_name."Request";
}



function get_response_name($table_name)
{

	return	$table_name."Response";
}



function get_service_name($table_name)
{

	return	$table_name."Service";
}



function get_i_service_name($table_name)
{

	return	"I".$table_name."Service";
}







?>
