<?php include_once("header.php"); ?>

<?php
include("singularize.php");
include("model.php");
include("controller.php");
include("repositories.php");
include("constant.php");
include("request_dto.php");
include("response_dto.php");
include("service.php");
include("i_service.php");
include("yml.php");
include("functions.php");
include("config.php");
include("create_zip_file.php");

echo "<div class='col-sm-9'>";

$query=$_POST["query"];
// Create a MySQL table in the selected database
$result = mysqli_query($conn, $query);
if($result<1)
{
	echo "<h3 class='text-center text-danger'> Error in table structure</h3>";
	die();
}



$query_for_list_table="show tables from $dbname";		// find the table in the selected database
$result_for_list_table = mysqli_query($conn, $query_for_list_table);

if (!$result_for_list_table) {
	echo "<h3 class='text-center text-danger'> DB Error, could not list tables";
    echo 'MySQL Error: ' . mysqli_error();
    echo "</h3>";
    die();
}
$arr=array();
$table_list=array();
$counter=0;
while ($tables = mysqli_fetch_row($result_for_list_table))
{
	$counter++;
    //echo "Table: {$row[0]}\n";
	//print_r($tables);die();
	$arr=array();
	$table_name=$tables[0];

	$add_primary_key_query = add_primary_key($table_name);
	mysqli_query($conn,$add_primary_key_query) or die (mysqli_error());

	$add_auto_increament_query = add_auto_increament($table_name);
	mysqli_query($conn,$add_auto_increament_query) or die (mysqli_error());

	array_push($table_list, $tables[0]);
	$query_for_column="DESCRIBE  $table_name";		// find the column name from selected table
	$result_for_table_column=mysqli_query($conn,$query_for_column);

    $query_for_column_with_type="select `column_name`,`data_type`,`CHARACTER_MAXIMUM_LENGTH` as data_type_length,`column_key`, `extra` , `IS_NULLABLE` from 
                                information_schema.columns  where table_schema = '$dbname' and table_name = '$table_name' ";   // find the column name from selected table
	$result_for_table_column_with_type=mysqli_query($conn,$query_for_column_with_type);

	if (!$result_for_table_column) 
	{
	echo "<h3 class='text-center text-danger'> DB Error, could not list columns";
	echo 'MySQL Error: ' . mysqli_error();
	echo "</h3>";
	die();
	}

	while ($columns = mysqli_fetch_assoc($result_for_table_column_with_type))
	{
	array_push($arr, $columns);
	
	}
	//print_r($arr);die();

//	echo "<br/>---".$table_name_to_class=create_table_to_class_name($table_name);
//	echo "<br/>table name---".$table_name;
//	echo "<br/>model_name---".$model_name=get_model_name($table_name_to_class);
//	echo "<br/>constant var name---".$constant_var_name=get_constant_var_name($table_name);
//	echo "<br/>controller_name---".$controller_name=get_controller_name($model_name);
//	echo "<br/>repository_name---".$repository_name=get_repository_name($model_name);
//	echo "<br/>constant_name---".$constant_name=get_constant_name($model_name);
//	echo "<br/>request_name---".$request_name=get_request_name($model_name);
//	echo "<br/>response_name---".$response_name=get_response_name($model_name);
//	echo "<br/>service_name---".$service_name=get_service_name($model_name);
//	echo "<br/>i_service_var---".$i_service_var=get_i_service_var($model_name);
//	echo "<br/>i_service_name---".$i_service_name=get_i_service_name($model_name);
//	echo "<br/>yml_name---".$yml_name=$table_name;


	$table_name_to_class=create_table_to_class_name($table_name);
	$model_name=get_model_name($table_name_to_class);
	$constant_var_name=get_constant_var_name($table_name);
	$controller_name=get_controller_name($model_name);
	$repository_name=get_repository_name($model_name);
	$constant_name=get_constant_name($model_name);
	$request_name=get_request_name($model_name);
	$response_name=get_response_name($model_name);
	$service_name=get_service_name($model_name);
	$i_service_var=get_i_service_var($model_name);
	$i_service_name=get_i_service_name($model_name);
	$yml_name=$table_name;



	create_model($arr,$table_name,$model_name,$package_name,$author_name);
	create_controller($arr,$table_name,$controller_name,$model_name,$constant_name,$request_name,$response_name,$i_service_name,$i_service_var,$package_name,$constant_var_name,$author_name);
	create_repository($repository_name,$model_name,$package_name,$author_name);
	create_constant($constant_name,$constant_var_name,$model_name,$package_name,$author_name);
	create_request_dto($arr,$table_name,$request_name,$model_name,$package_name,$author_name);
	create_response_dto($arr,$table_name,$response_name,$model_name,$package_name,$author_name);
	create_i_service($i_service_name,$request_name,$response_name,$model_name,$package_name,$author_name);
	create_service($service_name,$request_name,$response_name,$model_name,$package_name,$author_name,$i_service_name,$repository_name);
	create_yml($arr,$table_name,$yml_name,$model_name,$author_name);
	create_yml_change_log($table_name,$yml_name);

	drop_table($table_name,$conn);

	forZip("data/",$user_folder_name);


	$cookie_name = "download_file_src";
	$cookie_value = "download.php?file=$user_folder_name";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

	echo "<h1 class='text-success text-center'> Your create,read, update and delete code has been create and ready for use </h1>";
	echo "<h4 class='text-info text-center'><a href='download.php?file=$user_folder_name'> Please Download from here  </h4>";
	echo "<div class='col-xs-4 col-xs-offset-4'> <img src='images/zip.jpg' height='150px'/> </div>";

	echo "</div>";

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






?>
<?php include_once("footer.php"); ?>

