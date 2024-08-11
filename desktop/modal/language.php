<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$actualLanguage = config::byKey('language');
?>

<h3>{{Choix de la langue}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image" style="max-width:100%">
<p>
  <strong>{{Vous pouvez changer la langue de votre installation ou passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
</p>
<div class="input-group col-md-4 col-md-offset-4">
  <select class="form-control roundedLeft" id="in_language" style="width:350px">
    <option value="fr_FR" <?= ($actualLanguage == 'fr_FR') ? ' selected' : '' ?>>Français</option>
    <option value="en_US" <?= ($actualLanguage == 'en_US') ? ' selected' : '' ?>>English</option>
    <option value="de_DE" <?= ($actualLanguage == 'de_DE') ? ' selected' : '' ?>>Deutsch</option>
    <option value="es_ES" <?= ($actualLanguage == 'es_ES') ? ' selected' : '' ?>>Español</option>
    <option value="it_IT" <?= ($actualLanguage == 'it_IT') ? ' selected' : '' ?>>Italiano (nessun supporto)</option>
    <option value="pt_PT" <?= ($actualLanguage == 'pt_PT') ? ' selected' : '' ?>>Português (sem apoio)</option>
  </select>
  <span class="input-group-btn">
    <button type="button" class="btn btn-success roundedRight" id="btn_language">{{Valider}}</button>
  </span>
</div>

<script>
  document.getElementById('btn_language').addEventListener('click', function(_event) {
    let newLanguage = document.getElementById('in_language').value
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
        jeedomUtils.showAlert({
          message: '{{La langue a été changée}}',
          level: 'success',
          timeOut: 3000
        })
        document.getElementById('in_language').value = newLanguage
      }
    })
  })
</script>
