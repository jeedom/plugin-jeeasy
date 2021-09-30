<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

?>

		<script>
			$('#bt_next').hide();
			$('#bt_prev').hide();
			$('#bt_recovery').off('click').on('click', function () {
				$('#md_modal').dialog({title: "{{Lancement Recovery}}"}).load('index.php?v=d&plugin=atlas&modal=recovery.atlas&typeDemande=emmc').dialog('open');
			});
		</script>


      <div class="col-md-12 text-center"><h2>{{Recovery Atlas}}</h2></div>
      <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
      <div class="col-md-12 text-center">
				<button type="button" class="btn btn-primary" id="bt_recovery">{{LANCER LE RECOVERY}}</button>
      </div>
      </div>
