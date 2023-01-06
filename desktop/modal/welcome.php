<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

jeeasy::initStartBox();

?>



<div class="col-md-12 text-center">
	<h2>{{Guide de démarrage}} <?php echo config::byKey('product_name'); ?></h2>
</div>
<div class="col-md-8 col-md-offset-2 text-center"><img class="img-responsive center-block" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
	<p class="text-center"><br />{{Ce guide va vous aider à configurer votre}} <?php echo config::byKey('product_name'); ?> {{en quelques étapes.}}</p>
	<p class="text-center"><br />{{Cliquez sur la flèche pour commencer la configuration.}}</p>
</div>
<div class="col-md-12 text-center">
	<h4 style="color:red;">IL EST IMPORTANT DE TERMINER CETTE CONFIGURATION : plusieurs plugins essentiels seront installés durant le processus.</h4>
	<h4>Ne fermez pas cette fenetre jusqu'a son terme.</h4>
</div>
