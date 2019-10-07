<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div class="col-md-12 text-center"><h2>{{Guide de démarrageee <?php echo config::byKey('product_name'); ?>}}</h2></div>
<div class="col-md-12 text-center"><img class="img-responsive center-block" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center"><p class="text-center"><br/>{{Ce guide va vous aider à configurer votre <?php echo config::byKey('product_name'); ?> en quelques étapes.}}</p>
<p class="text-center"><br/>{{Cliquez sur la flêche pour commencer la configuration.}}</p>
</div>
