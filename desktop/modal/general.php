<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

if (strpos(shell_exec('cat /etc/hostname'), 'Luna') !== false) {
  config::save('hardware_name', "Luna");
}
$productName = jeedom::getHardwareName();

$boxName = config::byKey('name');
if ($boxName == '') {
  $boxName = 'Jeedom ' . ucfirst($productName);
  config::save('name', $boxName);
}
?>

<h3>{{Paramètres généraux}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<p>
  <strong>{{Vous pouvez modifier certains paramètres généraux de votre installation et passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
</p>
<div class="input-group">
  <span class="input-group-addon roundedLeft">{{Nom}}</span>
  <input type="text" class="form-control" id="in_boxName" value="<?= $boxName ?>">
</div>

<script>
  document.getElementById('in_boxName').addEventListener('change', function(_event) {
    configSave({
      name: this.value
    })
  })
</script>
