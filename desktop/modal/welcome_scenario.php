<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

?>


<div class="mainContainer" style="height:100%;">
<div class="col-md-12 text-center">
	<h2>{{Guide de démarrage}} <?php echo config::byKey('product_name'); ?></h2>
</div>
<div class="col-md-8 col-md-offset-2 text-center"><img class="img-responsive center-block" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
	<p class="text-center" style="font-size:2em;"><br />{{Ce guide va vous aider à créér vos premiers scénarios en quelques étapes.}}</p>

</div>
</div>


<script>
	document.getElementById('contentModal').style.height = '70vh';
</script>