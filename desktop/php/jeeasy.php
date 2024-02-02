<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<div class="row row-overflow" >

	<div class="col-xs-12 eqLogicThumbnailDisplay" >

		<div class="eqLogicThumbnailContainer">
			<legend style="margin-bottom:50px;"><i class="fas fa-cog"></i>  {{Bienvenue sur la configuration facile avec Jeeasy}}</legend>

			<div class="cursor eqLogicAction logoPrimary" id="bt_jeeasyWizard">
					<i class="fas fa-hat-wizard iconTableJeeasy"></i>
				<br>
				<span>{{Relancer le wizard}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" id="bt_jeeasyDiscovery">
				<i class="fas fa-wifi iconTableJeeasy"></i>
				<br>
				<span>{{Détecter mes équipements}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" id="bt_jeeasyObjectConfiguration">
				<i class="fas fa-home iconTableJeeasy"></i>
				<br>
				<span>{{Configurer ma maison}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" id="bt_jeeasyIncludeConfiguration">
				<i class="fas fa-plus iconTableJeeasy"></i>
				<br>
				<span>{{Ajouter un équipement}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" id="bt_jeeasyEqLogicConfiguration">
				<i class="fas fa-wrench iconTableJeeasy"></i>
				<br>
				<span>{{Configurer un équipement}}</span>
			</div>
		</div>
	</div>

</div>

<!-- Inclusion du fichier javascript du plugin (dossier, nom_du_fichier, extension_du_fichier, id_du_plugin) -->


<?php include_file('desktop', 'jeeasy', 'js', 'jeeasy');?>
<?php include_file('desktop', 'common', 'js', 'jeeasy');?>
<!-- Inclusion du fichier javascript du core - NE PAS MODIFIER NI SUPPRIMER -->
<?php include_file('core', 'plugin.template', 'js');?>
