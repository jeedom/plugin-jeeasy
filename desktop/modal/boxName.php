<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

if (strpos(shell_exec('cat /etc/hostname'), 'Luna') !== false) {
  config::save('hardware_name', "Luna");
}
$productName = jeedom::getHardwareName();

$nameBox = config::byKey('name');
if ($nameBox == '') {
  $nameBox = 'Jeedom ' . ucfirst($productName);
  config::save('name', $nameBox);
}
?>

<h3>{{Nom de l'installation}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="text-center">
  <p>
    <strong>{{Vous pouvez changer le nom de votre installation ou passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
  </p>
  <br>
  <input type="text" class="form-control" id="in_boxName" value="<?= $nameBox ?>">
</div>

<script>
  document.getElementById('in_boxName').addEventListener('change', function(_event) {
    let newBoxName = this.value

    jeedom.config.save({
      configuration: {
        name: newBoxName
      },
      error: function(_error) {
        jeedomUtils.showAlert({
          message: _error.message,
          level: 'danger'
        })
      },
      success: function() {
        console.log('new box name : ' + newBoxName)
      }
    })
  })
</script>
