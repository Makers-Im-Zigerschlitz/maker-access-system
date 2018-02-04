<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Refresh" content="5">
    <?php
      include "includes/logincheck.inc.php";
      if($_SESSION["level"] <3)
      {
        header("Location: noaccess.php");
        die();
      }
      include "../config/config.inc.php";
      include "../includes/dictionary.$language.inc.php";
      include "../includes/functions.inc.php";
        $db = new PDO('mysql:host=localhost;dbname=' . $mysqldb, $mysqluser, $mysqlpass);
     ?>
    <title><?php echo $orgname; ?> - Logs</title>
    <link rel="stylesheet" type="text/css" href="../css/log_viewer.css">
  </head>
  <body>
    <table class="table-fill">
      <thead>
        <tr>
          <th class="text-left">Status</th>
          <th class="text-left">Log ID</th>
          <th class="text-left">Timestamp</th>
          <th class="text-left">Action</th>
          <th class="text-left">User</th>
          <th class="text-left">Device ID</th>
          <th class="text-left">IP Address</th>
        </tr>
      </thead>
    <?php
    $stmt = $db->query('SELECT uid,username FROM tblUsers');
    while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) { 
          $members[$temp["uid"]] = $temp["username"];
      }
      $stmt = $db->query('SELECT * FROM tblLogs ORDER BY logID ASC');


      echo "<tbody class='table-hover'>";
        while ($logentry = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        if (strpos($logentry["action"], "Error") !== false) {
            echo "<td><img class='status' src='../img/error.png' alt=''></td>";
        }
        else {
          echo "<td><img class='status' src='../img/ok.png' alt=''></td>";
        }
        echo "<td class='text-left'>".$logentry["logID"]."</td>";
        echo "<td class='text-left'>".$logentry["timestamp"]."</td>";
        echo "<td class='text-left'>".$logentry["action"]."</td>";
        echo "<td class='text-left'>".$members[$logentry["uid"]]."</td>";
        echo "<td class='text-left'>".$logentry["deviceID"]."</td>";
        echo "<td class='text-left'>".$logentry["r_host"]."</td>";
        echo "</tr>";
      }
     ?>
     </tbody>
     </table>
  </body>
</html>