<?php
if (!isConnect()) {
	throw new Exception('401 - {{Accès non autorisé}}');
}

$jsonrpc = repo_market::getJsonRpc();
$servicePack = '';
if ($jsonrpc->sendRequest('servicepack::info')) {
	$servicePack = $jsonrpc->getResult()['licenceName'];
}
?>

<div class="mainContainer" style="display:flex;flex-direction:column;align-items:center;">
	<h2>{{Félicitations}} !</h2>
	<img src="plugins/jeeasy/core/img/greenthumb.png" alt="{{pouce de validation}}" style="width:10%;height:10%;">
	<h3>{{Vous avez terminé la phase de configuration}}</h3>
	<div class="divinformationsBox text-center" style="max-width:600px; font-weight:bold">
		{{Vous pouvez commencer à naviguer dans}} <?php echo config::byKey('product_name') ?> {{pendant que les plugins finissent de s'installer. Cette opération peut prendre jusqu'à 30 minutes.}}
	</div>

	<hr class="hrPrimary">

	<div class="internalDiv">
		<label style="color:#93ca02">{{Accès local à votre box}} :</label>
		<span id="divInternalIp" style="font-weight:bold;"><?= network::getNetworkAccess('internal'); ?></span>
	</div>
	<div class="externalDiv" id="externalDiv" style="display: <?= ($servicePack !== 'community') ? '' : 'none' ?>;">
		<label style="color:#93ca02;">{{Accès externe à votre box}} :</label>
		<span id="divExternalIp" style="font-weight:bold;">
			<?= (network::getNetworkAccess('external') == 'http:') ? '{{Le plugin Openvpn est en cours d installation, veuillez redémarrer le service DNS après son installation}}' : network::getNetworkAccess('external'); ?>
		</span>
	</div>

	<?php
	$mbState = config::byKey('mbState');
	if ($mbState == 0) {
	?>
		<hr class="hrPrimary">

		<p>{{Retrouvez la documentation Jeedom complète à cette adresse}} : <a href="https://www.jeedom.com/doc" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a></p>
		<p>{{Vous pouvez également rejoindre notre communauté}} : <a href="https://community.jeedom.com" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-users"></i> {{Communauté Jeedom}}</a></p>

	<?php
	}
	?>

	<br>
	<br>
	<br>
	<div style="align-self:flex-center;margin-right:20px;">
		{{Cliquez sur la coche en bas à droite}} <i class="fas fa-check-circle"></i> {{pour valider la configuration de votre box.}}
	</div>
</div>
