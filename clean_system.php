<?php include_once("header.php"); ?>

<?php
include("db_config.php");


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<div class='col-sm-9'>";

$result = mysqli_query($conn, "SHOW TABLES IN `$dbname`");
while ($table = mysqli_fetch_array($result)) {
    $tableName = $table[0];
    $query = "DROP TABLE `$dbname`.`$tableName`";
    mysqli_query($conn, $query);

    if (mysqli_errno($conn)) echo mysqli_errno($conn) . ' ' . mysqli_error($conn);
    else echo "";
}
echo "<h1 class='text-center'>System has cleared</h1> <p class='text-center'> Try again now please</p>";
echo "</div></div></div>";
?>

<?php include_once("footer.php"); ?>
