<?php
require "vendor/autoload.php";

use Cloudways\Server\Service\Service;
$service = new Service();
$service->SetEmail("mustaasam.saleem@cloudways.com");
$service->SetKey("DyhmAr7tGrajOCXys1NS94mEjfAeZ3");


$servers = $service->getServers();
foreach($servers->servers as $server){
    $serverId = $server->id;
}

$value = ['server_id' => $serverId];
$ser = $service->getServices($value);
unset($ser->services->status->elasticsearch_enabled,$ser->services->status->fpm_enabled,$ser->services->status->varnish_enabled,$ser->services->status->redis_enabled);


if(isset($_POST['submit'])){

echo $serverid = $_POST['server'];
echo $appservice = $_POST['app'];
echo $actions = $_POST['layout_select'];


$value = ['server_id' => $serverid, 'service' => $appservice, 'state' => $actions];


// die("aby ja na");

$doaction = $service->manageServices($value);
echo "<pre>";
var_dump($doaction->service_status->status);
echo "</pre>";
// if($doaction){
//   echo $appservice . "has sent some actions";
 }
// }



?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://code.jquery.com/jquery-1.10.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
 
<body>
 
  <div class="container-fluid">
 
    <div class="row">
 
      <div class="col-md-10">
 
        <form class="form-horizontal" method="post" action="index.php">
 
          <fieldset>
 
            <!-- Form Name -->
 
            <legend>Manage Services</legend>
 
            <!-- Select Basic -->
 
            <div class="form-group">
 
              <label class="col-md-4 control-label" for="server">Server</label>
 
              <div class="col-md-4">
 
                <select id="server" name="server" class="form-control">
 
                  <option value="">Select Your Server</option>
 
                  <?php foreach($servers->servers as $server) { echo "
                  <option value='".$server->id."'>".$server->label."</option>"; } ?>
 
                </select>
 
              </div>
 
            </div>
 
            <!-- Select Basic -->
 
            <div class="form-group">
 
              <label class="col-md-4 control-label" for="application">Services</label>
 
              <div class="col-md-4">
 
                <select id="app" name="app" class="form-control disable" onChange="changeaction(this.value);">
 
                </select>
 
              </div>
 
            </div>

                <div class="form-group">
 
              <label class="col-md-4 control-label" for="application">Action</label>
 
              <div class="col-md-4">
 
                <select name="layout_select" id="layout_select" class="form-control disable">
                    <!--<option value="Start">Start</option>
                    <option value="Stop">Stop</option>
                    <option value="Restart">Restart</option>-->

                </select>
 
              </div>
 
            </div>
 
            <!-- Button -->
 
            <div class="form-group">
 
              <label class="col-md-4 control-label" for=""></label>
 
              <div class="col-md-4">
 
                <button name="submit" class="btn btn-success">Do it</button>
 
                <span class="bg-success"><?php //echo $success  ?> </span>
 
              </div>
 
            </div>
 
          </fieldset>
 
        </form>
 
      </div>
 
    </div>
 
  </div>

<script>
var actionbyservice = {
    apache2: ["restart"],
    elasticsearch: ["start", "stop"],
    memcached: ["restart"],
    varnish: ["start", "stop", "purge"],
}

    function changeaction(value) {
        if (value.length == 0) document.getElementById("layout_select").innerHTML = "<option></option>";
        else {
            var catOptions = "";
            for (categoryId in actionbyservice[value]) {
                catOptions += "<option>" + actionbyservice[value][categoryId] + "</option>";
            }
            document.getElementById("layout_select").innerHTML = catOptions;
        }
    }
</script>





  <script type="text/javascript">
  $("#server").change(function () {
    val = $(this).val();
    switch (val) {
      <?php foreach($servers -> servers as $server) { ?>
        case <?php echo "\"".$server -> id.
        "\""; ?> :
          $('#app')
          .find('option')
          .remove()
          .end();
          <?php $i = "<option value=''>Select Your Application</option>";
          foreach($ser->services->status as $key => $value){
              $i .= "<option value='".$key."'>".$key."</option>";
              $i++;
            } ?>
            apps = "<?php echo $i;?>";
          $('#app').html(apps);
          break;
          <?php
        } ?>
        default:
        $('#app')
      .find('option')
      .remove()
      .end();
      break;
    }
  });
  </script>
 
</body>
 
</html>
