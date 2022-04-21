<?php


$author_name = $_REQUEST['author_name'];
$user_folder_name = spaceRemove($author_name)."_".time();
$folder_directory="data/".$user_folder_name."/";
$package_name = $_REQUEST['package'];
$package_url = str_replace(".","/",$package_name);
$package_url = $folder_directory."src/main/java/".$package_url;
$model_url = $package_url."/model";
$controller_url = $package_url."/controller";
$repository_url = $package_url."/repositories";
$constant_url = $package_url."/constants";
$service_url = $package_url."/service";
$i_service_url = $package_url."/service/IService";
$payload_url = $package_url."/payload";
$yml_url = $folder_directory."src/main/resources/db.changelog/changes/v1.0/tables";
$yml_changelog_url = $folder_directory;



//// Make a MySQL Connection
//mysql_connect("localhost", $username, $password) or die(mysql_error());
//mysql_select_db($dbname) or die(mysql_error());


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
