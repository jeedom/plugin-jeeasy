<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
jeeasy::checkPlugin('openenocean');
?>
<div id="div_AlertJeeasyInclude"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-plus"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="include"><a><i class="fas fa-wifi"></i> {{Inclusion}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="configure"><a><i class="fas fa-wrench"></i> {{Configuration}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="end"><a><i class="fas fa-check"></i> {{Fin}}</a></li>
			</ul>
		</div>
	</div>

	<div class="col-lg-10" id="div_jeeasyIncludeDisplay">
		<a class="btn btn-sm btn-success pull-left bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a>
		<a class="btn btn-sm btn-success pull-right bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a>
		<a class="btn btn-sm btn-default pull-right bt_jeeasyPrevious"><i class="fas fa-angle-double-left"></i> {{Précédent}}</a>
		<br/><br/>
		<div class="jeeasyDisplay home">
			<center><i class="fas fa-plus" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Très bien ajoutons un module à votre domotique.}}</div></center>
			<center>{{Cliquez sur suivant pour commencer}}</center>
			<br/>
			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>
		</div>

		<div class="jeeasyDisplay include" style="display:none;">
			<center><i class="fas fa-wifi" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{C'est parti, lançons nous. Cliquez sur le bouton "inclusion" pour démarrer l'ajout}}</div></center>
			<br/>
			<?php
if (config::byKey('include_mode', 'openenocean', 0) == 1) {
	echo '<div class="alert jqAlert alert-warning" id="div_inclusionAlert" style="margin : 0px 5px 15px 15px; padding : 7px 35px 7px 15px;">{{Vous êtes en mode inclusion. Recliquez sur le bouton d\'inclusion pour sortir de ce mode}}</div>';
} else {
	echo '<div id="div_inclusionAlert"></div>';
}
if (config::byKey('include_mode', 'openenocean', 0) == 1) {
	echo '<center><a class="btn btn-sm btn-success changeIncludeState include" data-mode="1" data-state="0"><i class="fas fa-sign-in-alt fa-rotate-90"></i> {{Arrêter inclusion}}</a></center>';
} else {
	echo '<center><a class="btn btn-sm btn-success changeIncludeState include" data-mode="1" data-state="1"><i class="fas fa-sign-in-alt fa-rotate-90"></i> {{Mode inclusion}}</a></center>';
}
?>
		</div>

		<div class="jeeasyDisplay configure" style="display:none;">
			<center><i class="fas fa-wrench" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Nous aimerions avoir quelques informations pour mieux connaitre votre nouveau module}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Comment voulez vous appeler votre nouveau module ?}}</label>
						<div class="col-xs-4">
							<input type="text" class="eqLogicAttr form-control" data-l1key="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Dans quelle pièce se trouve votre module ?}}</label>
						<div class="col-xs-4">
							<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
								<option value="">{{Aucun}}</option>
								<?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
							</select>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay end" style="display:none;">
			<center><i class="fas fa-check" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini d'ajouter votre module}}</div></center>
			<center>{{Cliquez sur sauvegarder pour valider votre configuration}}</center>
			<br/>
			<center><a class="btn btn-success bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a></center>
			<br/>
			<center><a class="btn btn-default bt_jeeasyEqLogicConfigurationAfterInclude" style="display:none;"><i class="fas fa-cogs"></i> {{Configurer}}</a></center>
		</div>

	</div>
</div>
<?php include_file('desktop', 'openenocean', 'js', 'openenocean');?>
<script type="text/javascript">
	eqLogic_id = null;
	$('.bt_jeeasyNext').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').next().click();
	});
	$('.bt_jeeasyPrevious').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').prev().click();
	});
	$('.li_jeeEasySummary').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').removeClass('active');
		$(this).addClass('active');
		$('.jeeasyDisplay').hide();
		$('.jeeasyDisplay.'+$(this).attr('data-href')).show();
		$(this).attr('data-display',1);
	});

	$('.bt_jeeasyEqLogicConfigurationAfterInclude').off('click').on('click',function(){
		bootbox.prompt({
			title: "{{Très bien configurons ce module. Quel est sont type ?}}",
			inputType: 'select',
			inputOptions:JEEASY_TYPE_LIST,
			callback: function (type) {
				jeeasyModalConfigurationEqLogic(eqLogic_id,type);
			}
		});
	});

	$('.bt_jeeasySave').off('click').on('click',function(){
		if(eqLogic_id == null){
			$('#div_AlertJeeasyInclude').showAlert({message: '{{Malheureusement nous ne trouvons pas votre module. Essayez de l\'inclure avant de sauvegarder sa configuration}}', level: 'danger'});
			return;
		}
		var eqLogic = {id : eqLogic_id}
		eqLogic = deepmerge(eqLogic,$('#div_jeeasyIncludeDisplay').getValues('.eqLogicAttr')[0]);
		jeedom.eqLogic.simpleSave({
			eqLogic: eqLogic,
			error: function (error) {
				$('#div_AlertJeeasyInclude').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				$('#div_AlertJeeasyInclude').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
				$('.bt_jeeasyEqLogicConfigurationAfterInclude').show();
			}
		});
	});

	$('body').off('openenocean::includeState').on('openenocean::includeState', function (_event,_options) {
		if (_options['mode'] == 'learn') {
			if (_options['state'] == 1) {
				if($('.include').attr('data-state') != 0){
					$.hideAlert();
					$('.include').attr('data-state', 0);
					$('.changeIncludeState').html('<i class="fas fa-sign-in-alt fa-rotate-90"></i> {{Arrêter inclusion}}');
					$('#div_inclusionAlert').showAlert({message: '{{Vous êtes en mode inclusion. Recliquez sur le bouton d\'inclusion pour sortir de ce mode}}', level: 'warning'});
				}
			} else {
				if($('.include').attr('data-state') != 1){
					$.hideAlert();
					$('.include').attr('data-state', 1);
					$('.changeIncludeState').html('<i class="fas fa-sign-in-alt fa-rotate-90"></i> {{Mode inclusion}}');
					$('.include.card').css('background-color','#ffffff');
				}
			}
		}
	});

	$('body').off('openenocean::includeDevice').on('openenocean::includeDevice', function (_event,_options) {
		$('#div_inclusionAlert').showAlert({message: '{{Félicitation !!! Votre module a bien été inclus. Vous pouvez passer à la suite}}', level: 'success'});
		eqLogic_id = _options;
		jeedom.eqLogic.byId({
			id: eqLogic_id,
			error: function (error) {
				$('#div_AlertJeeasyFridge').showAlert({message: error.message, level: 'danger'});
			},
			success: function (data) {
				$('#div_jeeasyDisplay').setValues(data,'.eqLogicAttr');
			}
		});
	});
</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
