<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<h3>{{Accès externe}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
