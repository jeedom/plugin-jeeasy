<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}
$pluginId = 4195;
$plugin = jeeasy::getPluginDetails($pluginId);
$plugin['id'] = $pluginId;
sendVarToJS('_plugin', $plugin);
?>

<h3>{{Plugin}} <?= $plugin['name'] ?></h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="bold toggle-visibility <?= ($plugin['installed'] ? ' hidden' : '') ?>" id="jeeasy-loading">
  <i class="fas fa-spinner fa-spin"></i> {{Le plugin <?= $plugin['name'] ?> est en cours d'installation, veuillez patienter un instant...}}
</div>
<div class="bold toggle-visibility <?= ($plugin['installed'] ? '' : ' hidden') ?>">{{Le plugin <?= $plugin['name'] ?> est installé, vous pouvez passer à l'étape suivante}}
  <i class="far fa-arrow-alt-circle-right"></i>
</div>

<div class="flex-evenly" id="plugins">
  <div class="plugin<?= ($plugin['installed'] ? ' selected' : '') ?>" data-id="<?= $plugin['id'] ?>" data-logicalid="<?= $plugin['logicalId'] ?>" data-installed="<?= $plugin['installed'] ?>" title="<?= $plugin['description'] ?>">
    <div class="bold plugin-name">
      <i class="fas fa-check-circle icon_blue toggle-visibility <?= ($plugin['installed'] ? '' : ' hidden') ?>" title="{{Installé}}"></i>
      <i class="fas fa-spinner fa-spin toggle-visibility <?= ($plugin['installed'] ? ' hidden' : '') ?>" title="{{Installation en cours...}}"></i>
      <?= $plugin['name'] ?>
    </div>
    <img src="<?= $plugin['icon'] ?>" alt="{{Icone du plugin}}">
    <div class="plugin-category"><?= $plugin['category'] ?></div>
  </div>
</div>

<script>
  if (_plugin.installed != 1) {
    allowNext(false)
    setTimeout(() => {
      installPlugin(_plugin.id, _plugin.logicalId, false)
      document.querySelectorAll('.toggle-visibility').forEach(_toggle => {
        _toggle.classList.toggle('hidden')
      })
      let plugin = document.getElementById('plugins').querySelector('.plugin')
      plugin.addClass('selected')
      plugin.dataset.installed = 1
      allowNext()
    }, 1500)
  }
</script>
