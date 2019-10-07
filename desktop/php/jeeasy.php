<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<br/>
<!--<div class="alert alert-info"><center>{{Bienvenu sur la page de configuration facile de Jeedom. Que voulez-vous faire ?}}</center></div>
<div class="row">

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div style="background-color:#f5f5f5;padding: 10px !important;" class="cursor" id="bt_jeeasyMainConfiguration">
			<center><i class="fa fa-cog" style="font-size: 15em;"></i></center>
			<center>{{Configuration mon }}<?php echo config::byKey('product_name'); ?></center>
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div style="background-color:#f5f5f5;padding: 10px !important;" class="cursor" id="bt_jeeasyObjectConfiguration">
			<center><i class="fa fa-home" style="font-size: 15em;"></i></center>
			<center>{{Configuration ma maison}}</center>
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div style="background-color:#f5f5f5;padding: 10px !important;" class="cursor" id="bt_jeeasyIncludeConfiguration">
			<center><i class="fa fa-plus" style="font-size: 15em;"></i></center>
			<center>{{Ajouter un équipement}}</center>
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div style="background-color:#f5f5f5;padding: 10px !important;" class="cursor" id="bt_jeeasyEqLogicConfiguration">
			<center><i class="fa fa-pencil-square-o" style="font-size: 15em;"></i></center>
			<center>{{Configuration un équipement}}</center>
		</div>
	</div>

</div>-->

Très bientôt de nouveaux wizards de configuration.

<?php include_file('desktop', 'jeeasy', 'js', 'jeeasy');?>
