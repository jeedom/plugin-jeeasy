<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
if (jeeasy::getWizardMode() == 'recovery') {
?>
	<h3>{{Assistant de restauration}}</h3>
	<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
	<div>{{Bienvenue dans l'assistant de restauration système}} <?php echo config::byKey('product_name'); ?>.</div>
	<div>{{Préparez facilement la restauration système de votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</div>
<?php
} else {
?>
	<h3>{{Assistant de configuration}}</h3>
	<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
	<div>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</div>
	<div>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</div>
<?php
}
$language = config::byKey('language');
?>
<div class="bold">{{Choisissez la langue puis cliquez sur la flèche en bas à droite pour commencer}}
	<i class="far fa-arrow-alt-circle-right"></i>
</div>

<div class="input-group">
	<span class="input-group-addon roundedLeft">{{Langue}}
		<sup><i class="fas fa-question-circle" title="{{Sélectionner la langue du système}}"></i></sup>
	</span>
	<select class="form-control roundedRight" id="sel_language">
		<option value="fr_FR" <?= ($language == 'fr_FR') ? ' selected' : '' ?>>Français</option>
		<option value="en_US" <?= ($language == 'en_US') ? ' selected' : '' ?>>English</option>
		<option value="de_DE" <?= ($language == 'de_DE') ? ' selected' : '' ?>>Deutsch</option>
		<option value="es_ES" <?= ($language == 'es_ES') ? ' selected' : '' ?>>Español</option>
		<option value="it_IT" <?= ($language == 'it_IT') ? ' selected' : '' ?>>Italiano (nessun supporto)</option>
		<option value="pt_PT" <?= ($language == 'pt_PT') ? ' selected' : '' ?>>Português (sem apoio)</option>
	</select>
</div>

<script>
	jeedomUtils.initTooltips()
	document.getElementById('sel_language').addEventListener('change', function(_event) {
		configSave({
			language: this.value
		})
	})
</script>
