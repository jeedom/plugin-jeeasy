<?php
if (!isConnect()) {
	throw new Exception('401 - {{Accès non autorisé}}');
}
?>
<h3>{{Félicitations}} !</h3>
<img src="plugins/jeeasy/core/img/greenthumb.png" alt="{{pouce de validation}}" style="width:180px;">
<div>
	<?= sprintf(__("Vous pouvez commencer à naviguer dans %s pendant que les plugins finissent de s'installer.", __FILE__), config::byKey('product_name')) ?>
	<br>
	{{Cette opération peut prendre jusqu'à 30 minutes.}}
</div>

<div class="bold">{{Cliquez sur la coche en bas à droite}} <i class="fas fa-check-circle"></i> {{pour valider la configuration de votre installation.}}</div>

<?php
if (jeeasy::getWizardMode() !== 'mb') {
?>
	<hr class="hrPrimary">
	<div>
		{{Retrouvez la documentation complète}} : <a href="<?= jeeasy::getDocUrl('home') ?>" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a>
		<br><br>
		{{Rejoignez la communauté}} : <a href="https://community.jeedom.com" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-users"></i> {{Forum}}</a>
	</div>
<?php
}
?>
