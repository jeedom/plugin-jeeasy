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
$cmd_temperature = $eqLogic->getCmdByGenericType('info', 'TEMPERATURE');
if (is_object($cmd_temperature)) {
	sendVarToJs('cmd_temperature_id', $cmd_temperature->getId());
}
?>

<div id="div_AlertJeeasyFridge"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-thermometer-half"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="display"><a><i class="fas fa-tv"></i> {{Affichage}}</a></li>
				<?php if (is_object($cmd_temperature)) {?>
					<li class="cursor li_jeeEasySummary" data-href="alerts"><a><i class="fas fa-exclamation-triangle"></i> {{Alerte}}</a></li>
					<li class="cursor li_jeeEasySummary" data-href="history"><a><i class="fas fa-line-chart"></i> {{Historique}}</a></li>
				<?php }?>
				<li class="cursor li_jeeEasySummary" data-href="battery"><a><i class="fas fa-battery-half"></i> {{Batterie}}</a></li>
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
			<center><i class="fas fa-thermometer-half" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Très bien configurons ensemble votre frigo : }}<strong><?php echo $eqLogic->getHumanName() ?></strong></div></center>
			<center>{{Cliquez sur suivant pour commencer}}</center>
			<br/>
			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>
		</div>

		<div class="jeeasyDisplay display" style="display:none;">
			<center><i class="fas fa-tv" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer l'affichage de votre frigo à travers quelque(s) question(s) très simple}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Voulez vous voir votre frigo sur le dashboard ?}}</label>
						<div class="col-xs-1">
							<input type="checkbox" class="eqLogicAttr" data-l1key="isVisible"/> {{Oui}}
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay alerts" style="display:none;">
			<center><i class="fas fa-exclamation-triangle" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer des alertes sur votre frigo en cas de soucis à travers quelque(s) question(s) très simple}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-8 control-label">{{Voulez-vous être alerté si la température de celui-ci est trop basse ? Si oui en-dessous de combien de °C ?}}</label>
						<div class="col-xs-1">
							<input type="number" class="cmd_temperatureAttr form-control" data-l1key="configuration" data-l2key="jeeasy_min_value" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-8 control-label">{{Voulez-vous être alerté si la température de celui-ci est trop haute ? Si oui au-dessus de combien de °C ?}}</label>
						<div class="col-xs-1">
							<input type="number" class="cmd_temperatureAttr form-control" data-l1key="configuration" data-l2key="jeeasy_max_value" >
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay history" style="display:none;">
			<center><i class="fas fa-line-chart" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer la gestion de l'historique de la température de votre frigo}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Voulez vous historiser la température de votre frigo ?}}</label>
						<div class="col-xs-1">
							<input type="checkbox" class="cmd_temperatureAttr" data-l1key="isHistorized"/> {{Oui}}
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay battery" style="display:none;">
			<center><i class="fas fa-battery-half" style="font-size: 10em;"></i></center>
			<center><div class="alert alert-info">{{Nous allons ici configurer la gestion de la batterie (si le module est sur batterie sinon vous pouvez passer à l'étape suivante)}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-8 control-label">{{A combien de % de batterie restant souhaitez vous être prévenu (en %) ?}}</label>
						<div class="col-xs-1">
							<input type="number" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="battery_danger_threshold" >
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
			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini de configurer votre frigo :  }}<strong><?php echo $eqLogic->getHumanName() ?></strong></div></center>
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

	$('.bt_jeeasySave').off('click').on('click',function(){
		var eqLogic = {id : eqLogic_id}
		if($('.li_jeeEasySummary[data-href=display]').attr('data-display') == 1){
			eqLogic = deepmerge(eqLogic,$('.jeeasyDisplay.display').getValues('.eqLogicAttr')[0]);
		}
		if($('.li_jeeEasySummary[data-href=battery]').attr('data-display') == 1){
			eqLogic = deepmerge(eqLogic,$('.jeeasyDisplay.battery').getValues('.eqLogicAttr')[0]);
		}
		if($('.li_jeeEasySummary[data-href=communication]').attr('data-display') == 1){
			eqLogic = deepmerge(eqLogic,$('.jeeasyDisplay.communication').getValues('.eqLogicAttr')[0]);
		}
		jeedom.eqLogic.simpleSave({
			eqLogic: eqLogic,
			error: function (error) {
				$('#div_AlertJeeasyFridge').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				if(!isset(cmd_temperature_id)){
					$('#div_AlertJeeasyFridge').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
					return;
				}
				var cmd_temperature = {id : cmd_temperature_id}
				if($('.li_jeeEasySummary[data-href=alerts]').attr('data-display') == 1){
					cmd_temperature = deepmerge(cmd_temperature,$('.jeeasyDisplay.alerts').getValues('.cmd_temperatureAttr')[0]);
					var dangerif = '';
					if(cmd_temperature.configuration.jeeasy_min_value != ''){
						dangerif += '#value# < '+ cmd_temperature.configuration.jeeasy_min_value;
					}
					if(cmd_temperature.configuration.jeeasy_max_value != ''){
						dangerif += ' || #value# > '+ cmd_temperature.configuration.jeeasy_max_value
					}
					dangerif =  $.trim($.trim(dangerif).replace(/^\|\||\|\|$/g,""));
					if(!isset(cmd_temperature.alert)){
						cmd_temperature.alert = {};
					}
					cmd_temperature.alert.dangerif = dangerif;
				}
				if($('.li_jeeEasySummary[data-href=history]').attr('data-display') == 1){
					cmd_temperature = deepmerge(cmd_temperature,$('.jeeasyDisplay.history').getValues('.cmd_temperatureAttr')[0]);
				}
				jeedom.cmd.save({
					cmd: cmd_temperature,
					error: function (error) {
						$('#div_AlertJeeasyFridge').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#div_AlertJeeasyFridge').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
					}
				});
			}
		});
	});

	jeedom.eqLogic.byId({
		id: eqLogic_id,
		error: function (error) {
			$('#div_AlertJeeasyFridge').showAlert({message: error.message, level: 'danger'});
		},
		success: function (data) {
			$('#div_jeeasyDisplay').setValues(data,'.eqLogicAttr');
		}
	});

	if(isset(cmd_temperature_id)){
		jeedom.cmd.byId({
			id: cmd_temperature_id,
			error: function (error) {
				$('#div_AlertJeeasyFridge').showAlert({message: error.message, level: 'danger'});
			},
			success: function (data) {
				$('#div_jeeasyDisplay').setValues(data,'.cmd_temperatureAttr');
			}
		});
	}
</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
