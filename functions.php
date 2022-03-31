<?php


function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
{

    $str = str_replace('_', '', ucwords($string, '_'));

    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}


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



function create_yml($arr,$table_name,$yml_name,$model_name,$author_name)
{
    global $yml_url;
    if (!file_exists($yml_url))
    {
        mkdir($yml_url, 0777, true);
    }


    $file = fopen($yml_url."/".$yml_name.".yml","w");
    $file_data=get_yml_data($arr,$table_name,$yml_name,$model_name,$author_name);
    fwrite($file,$file_data);
    fclose($file);
}


function create_yml_change_log($table_name,$yml_name)
{
    global $yml_url;
    if (!file_exists($yml_url))
    {
        mkdir($yml_url, 0777, true);
    }


    $file = fopen($yml_url."/db.table-changelog.yml","w");
    $file_data=get_yml_change_log_data($table_name,$yml_name);
    fwrite($file,$file_data);
    fclose($file);
}


function create_service($service_name,$request_name,$response_name,$model_name,$package_name,$author_name,$i_service_name,$repository_name)
{
    global $service_url;
    if (!file_exists($service_url))
    {
        mkdir($service_url, 0777, true);
    }


    $file = fopen($service_url."/".$service_name.".java","w");
    $file_data=get_service_data($service_name,$request_name,$response_name,$model_name,$package_name,$author_name,$i_service_name,$repository_name);
    fwrite($file,$file_data);
    fclose($file);
}



function create_i_service($i_service_name,$request_name,$response_name,$model_name,$package_name,$author_name)
{
    global $i_service_url;
    if (!file_exists($i_service_url))
    {
        mkdir($i_service_url, 0777, true);
    }


    $file = fopen($i_service_url."/".$i_service_name.".java","w");
    $file_data=get_i_service_data($i_service_name,$request_name,$response_name,$model_name,$package_name,$author_name);
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






