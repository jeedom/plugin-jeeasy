<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<h3>{{Assistant de configuration}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="text-center">
	<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
	<p>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
	<br>
	<strong>{{Cliquez sur la flèche en bas à droite pour commencer}} <i class='far fa-arrow-alt-circle-right'></i></strong>
</div>
