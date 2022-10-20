<?php
include("db_config.php");

$ip_address = $_SERVER['REMOTE_ADDR'];
$current_page = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['PHP_SELF'];
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
$created_date_time = date('Y-m-d H:i:s');
$user_agent = $_SERVER['HTTP_USER_AGENT'];



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$create_query = "CREATE TABLE IF NOT EXISTS visitor_details (
                          id int(11)  NOT NULL  AUTO_INCREMENT,
                          ip_address text,
                          current_page text,
                          referrer text,
                          created_date_time datetime,
                          user_agent text,
                          PRIMARY KEY  (id)
                          )";

$create_query_result = mysqli_query($conn, $create_query) or die(mysqli_error);
if($create_query_result<1)
{
   // echo "<h3 class='text-center text-danger'> Error in create table</h3>";
    mysqli_error($conn);
   die();
}

$visitors_insert_query = "insert into visitor_details values('','$ip_address','$current_page','$referrer','$created_date_time','$user_agent')";
$result = mysqli_query($conn, $visitors_insert_query);
if($result<1)
{
    echo "<h3 class='text-center text-danger'> Error in visitor details</h3>";
    die();
}
