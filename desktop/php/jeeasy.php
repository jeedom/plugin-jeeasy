<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<br/>
<div class="textInfoJeeasy">{{Bienvenue sur la page de configuration facile de}} <?php echo config::byKey('product_name'); ?></div>
<div class="row">

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyMainConfiguration">
			<i class="fas fa-cogs iconTableJeeasy"></i>
			<br />
			{{Configurer mon}} <?php echo config::byKey('product_name'); ?>
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyDiscovery">
			<i class="fas fa-wifi iconTableJeeasy"></i>
			<br />
			{{Détecter mes équipements}}
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyObjectConfiguration">
			<i class="fas fa-home iconTableJeeasy"></i>
			<br />
			{{Configurer ma maison}}
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyIncludeConfiguration">
			<i class="fas fa-plus iconTableJeeasy"></i>
			<br />
			{{Ajouter un équipement}}
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyEqLogicConfiguration">
			<i class="fas fa-wrench iconTableJeeasy"></i>
			<br />
			{{Configurer un équipement}}
		</div>
	</div>

	<div class="col-sm-4" style="margin-bottom: 10px;">
		<div class="cursor divTableJeeasy" id="bt_jeeasyWizard">
			<i class="fas fa-hat-wizard iconTableJeeasy"></i>
			<br />
			{{Relancer le Wizard}}
		</div>
	</div>

</div>

<?php include_file('desktop', 'jeeasy', 'js', 'jeeasy');?>
<?php include_file('desktop', 'jeeasy', 'css', 'jeeasy');?>
