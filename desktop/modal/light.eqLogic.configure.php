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
$eqLogic = eqLogic::byId(init('eqLogic_id'));
if (!is_object($eqLogic)) {
	echo '<div class="alert alert-danger">' . __('Désolé je n\'arrive pas à trouver votre équipement  : ', __FILE__) . init('eqLogic_id') . '</div>';
	die();
}
sendVarToJs('eqLogic_id', $eqLogic->getId());
$cmd_lighton = $eqLogic->getCmdByGenericType('action', 'LIGHT_ON');
if (is_object($cmd_lighton)) {
	sendVarToJs('cmd_lighton_id', $cmd_lighton->getId());
	sendVarToJs('cmd_lighton_humanename', $cmd_lighton->getHumanName());
}
$cmd_lightoff = $eqLogic->getCmdByGenericType('action', 'LIGHT_OFF');
if (is_object($cmd_lightoff)) {
	sendVarToJs('cmd_lightoff_id', $cmd_lightoff->getId());
	sendVarToJs('cmd_lightoff_humanename', $cmd_lightoff->getHumanName());
}
?>

<div id="div_AlertJeeasyLight"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-lightbulb"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="display"><a><i class="fas fa-tv"></i> {{Affichage}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="automate"><a><i class="fas fa-magic"></i> {{Automatisation}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="communication"><a><i class="fas fa-wifi"></i> {{Communication}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="end"><a><i class="fas fa-check"></i> {{Fin}}</a></li>
			</ul>
		</div>
	</div>

	<div class="col-lg-10" id="div_jeeasyDisplay">
		<a class="btn btn-sm btn-success pull-left bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a>
		<a class="btn btn-sm btn-success pull-right bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a>
		<a class="btn btn-sm btn-default pull-right bt_jeeasyPrevious"><i class="fas fa-angle-double-left"></i> {{Précédent}}</a>
		<br/><br/>
		<div class="jeeasyDisplay home">
			<center><i class="fas fa-lightbulb" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Très bien configurons ensemble votre lumière : }}<strong><?php echo $eqLogic->getHumanName() ?></strong></div></center>
			<center>{{Cliquez sur suivant pour commencer}}</center>
			<br/>
			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>
		</div>

		<div class="jeeasyDisplay display" style="display:none;">
			<center><i class="fas fa-tv" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer l'affichage de votre lumière à travers quelque(s) question(s) très simple}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Voulez vous voir votre lumière sur le dashboard ?}}</label>
						<div class="col-xs-1">
							<input type="checkbox" class="eqLogicAttr" data-l1key="isVisible"/> {{Oui}}
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay automate" style="display:none;">
			<center><i class="fas fa-robot" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer l'allumage automatique de votre lumière en fonction d'une présence ou non}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Créer le scénario}}</label>
						<div class="col-xs-3">
							<a class="btn btn-default" id="bt_jeeasyCreateScenario"><i class="fas fa-plus"></i> {{Créer le scénario}}</a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Quelle est la commande indiquant la présence ?}}</label>
						<div class="col-xs-4">
							<div class="input-group">
								<input type="text" class="cmd_onAttr form-control" data-l1key="configuration" data-l2key="jeeasyCmd_presence" />
								<span class="input-group-btn">
									<a class="btn btn-default" id="bt_jeeasySearchPresenceCmd"><i class="fas fa-list-alt"></i></a>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Quelle est la commande de luminosité (optionnel) ?}}</label>
						<div class="col-xs-4">
							<div class="input-group">
								<input type="text" class="cmd_onAttr form-control" data-l1key="configuration" data-l2key="jeeasyCmd_luminosity" />
								<span class="input-group-btn">
									<a class="btn btn-default" id="bt_jeeasySearchLuminosityCmd"><i class="fas fa-list-alt"></i></a>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Limite de luminosité ?}}</label>
						<div class="col-xs-4">
							<div class="input-group">
								<input type="number" class="cmd_onAttr form-control" data-l1key="configuration" data-l2key="jeeasyCmd_luminosity_threshold" />
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay communication" style="display:none;">
			<center><i class="fas fa-wifi" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer la surveillance de la communication entre votre équipement et}} <?php echo config::byKey('product_name'); ?></div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-8 control-label">{{Au bout de combien de temps en minutes souhaitez vous recevoir une alerte de non-communication du module ?}}</label>
						<div class="col-xs-1">
							<input type="number" class="eqLogicAttr form-control" data-l1key="timeout" >
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay end" style="display:none;">
			<center><i class="fas fa-check" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini de configurer votre lumière :  }}<strong><?php echo $eqLogic->getHumanName() ?></strong></div></center>
			<center>{{Cliquez sur sauvegarder pour valider votre configuration}}</center>
			<br/>
			<center><a class="btn btn-success bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a></center>
		</div>

	</div>
</div>

<script type="text/javascript">
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


	$("#bt_jeeasySearchPresenceCmd").off('click').on('click',  function () {
		jeedom.cmd.getSelectModal({cmd: {type: 'info', subType: 'binary'}}, function (result) {
			$('.cmd_onAttr[data-l2key=jeeasyCmd_presence]').value(result.human);
		});
	});

	$("#bt_jeeasySearchLuminosityCmd").off('click').on('click',  function () {
		jeedom.cmd.getSelectModal({cmd: {type: 'info', subType: 'numeric'}}, function (result) {
			$('.cmd_onAttr[data-l2key=jeeasyCmd_luminosity]').value(result.human);
		});
	});


	$('.bt_jeeasySave').off('click').on('click',function(){
		var eqLogic = {id : eqLogic_id}
		if($('.li_jeeEasySummary[data-href=display]').attr('data-display') == 1){
			eqLogic = deepmerge(eqLogic,$('.jeeasyDisplay.display').getValues('.eqLogicAttr')[0]);
		}
		if($('.li_jeeEasySummary[data-href=communication]').attr('data-display') == 1){
			eqLogic = deepmerge(eqLogic,$('.jeeasyDisplay.communication').getValues('.eqLogicAttr')[0]);
		}
		jeedom.eqLogic.simpleSave({
			eqLogic: eqLogic,
			error: function (error) {
				$('#div_AlertJeeasyLight').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				if(!isset(cmd_lighton_id)){
					$('#div_AlertJeeasyLight').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
					return;
				}
				var cmd_on = {id : cmd_lighton_id};
				if($('.li_jeeEasySummary[data-href=automate]').attr('data-display') == 1){
					cmd_on = deepmerge(cmd_on,$('.jeeasyDisplay.automate').getValues('.cmd_onAttr')[0]);
				}
				jeedom.cmd.save({
					cmd: cmd_on,
					error: function (error) {
						$('#div_AlertJeeasyLight').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#div_AlertJeeasyLight').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
					}
				});
			}
		});
	});

	jeedom.eqLogic.byId({
		id: eqLogic_id,
		error: function (error) {
			$('#div_AlertJeeasyLight').showAlert({message: error.message, level: 'danger'});
		},
		success: function (data) {
			$('#div_AlertJeeasyLight').setValues(data,'.eqLogicAttr');
		}
	});

	if(isset(cmd_lighton_id)){
		jeedom.cmd.byId({
			id: cmd_lighton_id,
			error: function (error) {
				$('#div_AlertJeeasyLight').showAlert({message: error.message, level: 'danger'});
			},
			success: function (data) {
				$('#div_jeeasyDisplay').setValues(data,'.cmd_onAttr');
			}
		});
	}


	$('#bt_jeeasyCreateScenario').off('click').on('click',function(){
		$('.bt_jeeasySave:first').trigger('click');
		var scenario_name = 'scenario.light.p';
		var replace = {'#light_presence#' : $('.cmd_onAttr[data-l2key=jeeasyCmd_presence]').value(),'#light_on#' : cmd_lighton_humanename,'#light_off#' : cmd_lightoff_humanename};
		if($('.cmd_onAttr[data-l2key=jeeasyCmd_luminosity]').value() != ''){
			var scenario_name = 'scenario.light.pl';
			replace['#light_luminosity#'] = $('.cmd_onAttr[data-l2key=jeeasyCmd_luminosity]').value();
			replace['#light_luminosity_threshold#'] = $('.cmd_onAttr[data-l2key=jeeasyCmd_luminosity_threshold]').value();
		}
		$.ajax({
			type: "POST",
			url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
			data: {
				action: "generateScenario",
				replace :json_encode(replace),
				name : scenario_name
			},
			global:false,
			dataType: 'json',
			error: function (request, status, error) {
				handleAjaxError(request, status, error,$('#div_AlertJeeasyLight'));
			},
			success: function (data) {
				if (data.state != 'ok') {
					$('#div_AlertJeeasyLight').showAlert({message: data.result, level: 'danger'});
					return;
				}
				jeedom.scenario.save({
					scenario : data.result,
					error: function (error) {
						$('#div_AlertJeeasyLight').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#div_AlertJeeasyLight').showAlert({message: '{{Scénario crée avec succès}}', level: 'success'});
					}
				});
			}
		});
	});
</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
