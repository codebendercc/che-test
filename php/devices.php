<?php $currentVersion = file_get_contents("/tmp/version") ?>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">


<div class="container-fluid" style="margin-top:20px">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h3>Known Devices
            <span class="small" style="float:right">Current Version:  <?php echo $currentVersion ?>
            </span>
        </h3>
<table class="table">
    <tr>
        <th>Device ID</th>
        <th>Latest Version</th>
        <th></th>
    </tr>
<?php

$devices = scandir("../devices/");

foreach($devices as $device)
{
    if(substr($device, 0, 1) == ".") continue;

    echo "<tr>";
    echo "<td>";
    echo $device;
    echo"</td>";
    echo "<td>";
    $deviceVersion = file_get_contents("../devices/".$device);
    echo $deviceVersion;
    echo"</td>";
    echo "<td>";
    if(intval($deviceVersion) == $currentVersion) echo "<i class='fa fa-check-circle' style='color: green;'></i>";
    else echo "<i class='fa fa-times-circle' style='color: chocolate;'></i>";
    echo"</td>";
    echo "</tr>";
}


?>
</table>

      </div>
  </div>
</div>
