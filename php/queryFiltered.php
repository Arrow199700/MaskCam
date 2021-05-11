<?php
include_once ("dbconnection.php");
$label = isset($_POST['label']) ? $_POST['label'] : "%";
$sql = "select count(*) as conteggio from mask_cam.mask where label like '" . $label . "'";
$conteggio = -1;
$result=mysqli_query($GLOBALS["link"], $sql);
while($row = $result->fetch_assoc()) {
    $conteggio = $row["conteggio"];
}
echo $conteggio;

?>
