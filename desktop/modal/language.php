<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$actualLanguage = config::byKey('language');
?>

<h3>{{Choix de la langue}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="text-center">
  <p>
    <strong>{{Vous pouvez changer la langue de votre installation ou passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
  </p>
  <br>
  <select class="form-control roundedLeft" id="in_language">
    <option value="fr_FR" <?= ($actualLanguage == 'fr_FR') ? ' selected' : '' ?>>Français</option>
    <option value="en_US" <?= ($actualLanguage == 'en_US') ? ' selected' : '' ?>>English</option>
    <option value="de_DE" <?= ($actualLanguage == 'de_DE') ? ' selected' : '' ?>>Deutsch</option>
    <option value="es_ES" <?= ($actualLanguage == 'es_ES') ? ' selected' : '' ?>>Español</option>
    <option value="it_IT" <?= ($actualLanguage == 'it_IT') ? ' selected' : '' ?>>Italiano (nessun supporto)</option>
    <option value="pt_PT" <?= ($actualLanguage == 'pt_PT') ? ' selected' : '' ?>>Português (sem apoio)</option>
  </select>
</div>
</div>

<script>
  document.getElementById('in_language').addEventListener('change', function(_event) {
    let newLanguage = this.value

    jeedom.config.save({
      configuration: {
        language: newLanguage
      },
      error: function(_error) {
        jeedomUtils.showAlert({
          message: _error.message,
          level: 'danger'
        })
      },
      success: function() {
        window.location.reload()
      }
    })
  })
</script>
