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

<h2>{{Nom de l'installation}}</h2>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image" style="max-width:100%">
<p>{{Le nom de votre box est}} : <strong id="boxName"><?= $nameBox ?></strong></p>
<p>{{Vous pouvez changer le nom de votre box ou passer à l'étape suivante.}}</p>
<div class="input-group col-md-6 col-md-offset-3">
  <input type="text" class="form-control roundedLeft" id="in_boxName" placeholder="{{Saisissez le nouveau nom puis validez}}">
  <span class="input-group-btn">
    <button type="button" class="btn btn-success roundedRight" id="btn_BoxName">{{Valider}}</button>
  </span>
</div>

<script>
  document.getElementById('btn_BoxName').addEventListener('click', function(_event) {
    let newBoxName = document.getElementById('in_boxName').value
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
        jeedomUtils.showAlert({
          message: '{{Le nouveau nom de votre box est}} : <strong>' + newBoxName + '</strong>',
          level: 'success',
          timeOut: 3000
        })
        document.getElementById('boxName').innerText = newBoxName
        document.getElementById('in_boxName').value = ''
      }
    })
  })
</script>
