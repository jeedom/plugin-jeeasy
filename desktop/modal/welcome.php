<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
if (jeeasy::getWizardMode() == 'recovery') {
?>
	<h3>{{Assistant de restauration}}</h3>
	<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
	<div class="text-center">
		<p>{{Bienvenue dans l'assistant de restauration système}} <?php echo config::byKey('product_name'); ?>.</p>
		<p>{{Préparez facilement la restauration système de votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
	</div>
<?php
} else {
?>
	<h3>{{Assistant de configuration}}</h3>
	<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
	<div class="text-center">
		<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
		<p>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
	</div>
<?php
}
$language = config::byKey('language');
?>

<div class="input-group">
	<span class="input-group-addon roundedLeft">{{Langue}}</span>
	<select class="form-control roundedRight" id="in_language">
		<option value="fr_FR" <?= ($language == 'fr_FR') ? ' selected' : '' ?>>Français</option>
		<option value="en_US" <?= ($language == 'en_US') ? ' selected' : '' ?>>English</option>
		<option value="de_DE" <?= ($language == 'de_DE') ? ' selected' : '' ?>>Deutsch</option>
		<option value="es_ES" <?= ($language == 'es_ES') ? ' selected' : '' ?>>Español</option>
		<option value="it_IT" <?= ($language == 'it_IT') ? ' selected' : '' ?>>Italiano (nessun supporto)</option>
		<option value="pt_PT" <?= ($language == 'pt_PT') ? ' selected' : '' ?>>Português (sem apoio)</option>
	</select>
</div>

<strong style="align-self:end">{{Cliquez sur la flèche en bas à droite pour commencer}} <i class='far fa-arrow-alt-circle-right'></i></strong>

<script>
	document.getElementById('in_language').addEventListener('change', function(_event) {
		configSave({
			language: this.value
		})
	})
</script>
