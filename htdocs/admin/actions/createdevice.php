<?php
include "../includes/logincheck.inc.php";
if($_SESSION["level"] <3)
{
  header("Location: ../noaccess.php");
  die();
}
include "../../config/config.inc.php";
include "../../includes/dictionary.$language.inc.php";
include "../../includes/functions.inc.php";
$db = new PDO('mysql:host='.$mysqlhost.';dbname='.$mysqldb, $mysqluser, $mysqlpass);
$stmt = $db->prepare("INSERT INTO tblDevices(deviceName,deviceDesc) VALUES (:deviceName,:deviceDesc)");
$stmt->bindValue(':deviceName', filter_input(INPUT_POST, 'deviceName'), PDO::PARAM_STR);
$stmt->bindValue(':deviceDesc', filter_input(INPUT_POST, 'deviceDesc'), PDO::PARAM_STR);
$stmt->execute();
if ($stmt->rowCount()>0) {
	header("Location: ../index.php?site=devices&message=devicecreated");
}
?>
