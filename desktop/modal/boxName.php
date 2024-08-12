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
<p>
  <strong>{{Vous pouvez changer le nom de votre installation ou passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
</p>
<br>
<div class="input-group">
  <input type="text" class="form-control roundedLeft" id="in_boxName" placeholder="{{Saisissez un nouveau nom puis validez}}">
  <span class="input-group-btn">
    <button type="button" class="btn btn-success roundedRight" id="btn_boxName">{{Valider}}</button>
  </span>
</div>
<p>{{Nom actuel}} : <strong id="boxName"><?= $nameBox ?></strong></p>

<script>
  document.getElementById('btn_boxName').addEventListener('click', function(_event) {
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
          message: '{{Le nouveau nom de votre installation est}} : <strong>' + newBoxName + '</strong>',
          level: 'success',
          timeOut: 3000
        })
        document.getElementById('boxName').innerText = newBoxName
        document.getElementById('in_boxName').value = ''
      }
    })
  })
</script>
