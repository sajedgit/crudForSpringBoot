<?php
include("singularize.php");
include("model.php");
include("controller.php");
include("repositories.php");
include("constant.php");
include("request_dto.php");
include("response_dto.php");
include("functions.php");



$db_name="crudForSpringBoot";
$user="root";
$pass="";

$author_name = "Md. Sajed Ahmed";
$package_name = "com.synesis.mofl.acl";
$package_url = str_replace(".","/",$package_name);
$model_url = "data/src/main/java/".$package_url."/model";
$controller_url = "data/src/main/java/".$package_url."/controller";
$repository_url = "data/src/main/java/".$package_url."/repositories";
$constant_url = "data/src/main/java/".$package_url."/constants";
$service_url = "data/src/main/java/".$package_url."/service";
$i_service_url = "data/src/main/java/".$package_url."/service/IService";
$payload_url = "data/src/main/java/".$package_url."/payload";

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
$table_list=array();
$counter=0;
while ($tables = mysql_fetch_row($result_for_list_table)) 
{
	$counter++;
    //echo "Table: {$row[0]}\n";
	//print_r($tables);die();
	$arr=array();
	$table_name=$tables[0];

	$add_primary_key_query = add_primary_key($table_name);
	mysql_query($add_primary_key_query) or die (mysql_error());

	$add_auto_increament_query = add_auto_increament($table_name);
	mysql_query($add_auto_increament_query) or die (mysql_error());

	array_push($table_list, $tables[0]);
	$query_for_column="DESCRIBE  $table_name";		// find the column name from selected table
	$result_for_table_column=mysql_query($query_for_column);

	$query_for_column_with_type="select `column_name`,`data_type`,`column_key`, `extra` , `IS_NULLABLE` from information_schema.columns where table_schema = '$db_name' and table_name = '$table_name' ";		// find the column name from selected table
	$result_for_table_column_with_type=mysql_query($query_for_column_with_type);

	if (!$result_for_table_column) 
	{
	echo "DB Error, could not list columns\n";
	echo 'MySQL Error: ' . mysql_error();
	die();
	}

	while ($columns = mysql_fetch_assoc($result_for_table_column_with_type))
	{
	array_push($arr, $columns);
	
	}
	//print_r($arr);die();

	echo "<br/>---".$table_name_to_class=create_table_to_class_name($table_name);
	echo "<br/>table name---".$table_name;
	echo "<br/>model_name---".$model_name=get_model_name($table_name_to_class);
	echo "<br/>constant var name---".$constant_var_name=get_constant_var_name($table_name);
	echo "<br/>controller_name---".$controller_name=get_controller_name($model_name);
	echo "<br/>repository_name---".$repository_name=get_repository_name($model_name);
	echo "<br/>constant_name---".$constant_name=get_constant_name($model_name);
	echo "<br/>request_name---".$request_name=get_request_name($model_name);
	echo "<br/>response_name---".$response_name=get_response_name($model_name);
	echo "<br/>service_name---".$service_name=get_service_name($model_name);
	echo "<br/>i_service_var---".$i_service_var=get_i_service_var($model_name);
	echo "<br/>i_service_name---".$i_service_name=get_i_service_name($model_name);
	echo "<br/>yml_name---".$yml_name=get_yml_name($table_name);

	create_model($arr,$table_name,$model_name,$package_name,$author_name);
	create_controller($arr,$table_name,$controller_name,$model_name,$constant_name,$request_name,$response_name,$i_service_name,$i_service_var,$package_name,$constant_var_name,$author_name);
	create_repository($repository_name,$model_name,$package_name,$author_name);
	create_constant($constant_name,$constant_var_name,$model_name,$package_name,$author_name);
	create_request_dto($arr,$table_name,$request_name,$model_name,$package_name,$author_name);
	create_response_dto($arr,$table_name,$response_name,$model_name,$package_name,$author_name);

	drop_table($table_name);
	die();
	
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



function add_primary_key($table_name)
{
	$query_for_primary_auto_increment="ALTER TABLE `$table_name`  ADD PRIMARY KEY (`id`)";
	return $query_for_primary_auto_increment;
}


function add_auto_increament($table_name)
{
	$query_for_primary_auto_increment="ALTER TABLE `$table_name` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	return $query_for_primary_auto_increment;
}


function drop_table($table_name)
{
	$sql = "DROP TABLE $table_name";
	$retval = mysql_query( $sql );
	if(! $retval )
	{
		die('Could not delete table: ' . mysql_error());
	}
	else
		echo "Table deleted successfully\n";
}

function create_model($arr,$table_name,$model_name,$package_name,$author_name)
{
	global $model_url;

	if (!file_exists($model_url))
	{
    mkdir($model_url, 0777, true);
	}

	
	$file = fopen($model_url."/".$model_name.".java","w");
	$file_data=get_model_data($arr,$table_name,$model_name,$package_name,$author_name);	//	get_model_data function are in include page
	fwrite($file,$file_data);
	fclose($file);

}


function create_controller($arr,$table_name,$controller_name,$model_name,$constant_name,$request_name,$response_name,$i_service_name,$i_service_var,$package_name,$constant_var_name,$author_name)
{
	global $controller_url;
	if (!file_exists($controller_url))
	{
    mkdir($controller_url, 0777, true);
	}

	
	$file = fopen($controller_url."/".$controller_name.".java","w");
	$file_data=get_controller_data($arr,$table_name,$controller_name,$model_name,$constant_name,$request_name,$response_name,$i_service_name,$i_service_var,$package_name,$constant_var_name,$author_name);	//	get_controller_data function are in include page
	fwrite($file,$file_data);
	fclose($file);
}



function create_repository($repository_name,$model_name,$package_name,$author_name)
{
	global $repository_url;
	if (!file_exists($repository_url))
	{
    mkdir($repository_url, 0777, true);
	}


	$file = fopen($repository_url."/".$repository_name.".java","w");
	$file_data=get_repository_data($repository_name,$model_name,$package_name,$author_name);
	fwrite($file,$file_data);
	fclose($file);
}



function create_constant($constant_name,$constant_var_name,$model_name,$package_name,$author_name)
{
	global $constant_url;
	if (!file_exists($constant_url))
	{
    mkdir($constant_url, 0777, true);
	}


	$file = fopen($constant_url."/".$constant_name.".java","w");
	$file_data=get_constant_data($constant_name,$constant_var_name,$model_name,$package_name,$author_name);
	fwrite($file,$file_data);
	fclose($file);
}



function create_request_dto($arr,$table_name,$request_name,$model_name,$package_name,$author_name)
{
	global $payload_url;
	if (!file_exists($payload_url))
	{
    mkdir($payload_url, 0777, true);
	}


	$file = fopen($payload_url."/".$request_name.".java","w");
	$file_data=get_request_dto_data($arr,$table_name,$request_name,$model_name,$package_name,$author_name);
	fwrite($file,$file_data);
	fclose($file);
}



function create_response_dto($arr,$table_name,$response_name,$model_name,$package_name,$author_name)
{
	global $payload_url;
	if (!file_exists($payload_url))
	{
    mkdir($payload_url, 0777, true);
	}


	$file = fopen($payload_url."/".$response_name.".java","w");
	$file_data=get_response_dto_data($arr,$table_name,$response_name,$model_name,$package_name,$author_name);
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



function get_constant_var_name($table_name)
{
	return strtoupper(singularize($table_name));
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

function get_i_service_var($table_name)
{

	return	"i".$table_name."Service";
}

function get_yml_name($table_name)
{

	return	$table_name."yml";
}







?>
