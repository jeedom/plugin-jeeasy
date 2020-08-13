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
global $JEEDOM_INTERNAL_CONFIG;
$keys = array('dns::token', 'market::allowDNS');
$repos = update::listRepo();
foreach ($repos as $key => $value) {
	$keys[] = $key . '::enable';
}
$configs = config::byKeys($keys);
?>

<div id="div_AlertJeeasyJeedomConfigure"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-home"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="main"><a><i class="fas fa-wrench"></i> {{Général}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="network"><a><i class="fas fa-wifi"></i> {{Réseaux}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="log"><a><i class="far fa-file"></i> {{Logs}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="eqLogic"><a><i class="icon divers-svg"></i> {{Equipement}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="market"><a><i class="far fa-credit-card"></i> {{Market}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="alerts"><a><i class="fas fa-bell"></i> {{Alertes}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="end"><a><i class="fas fa-check"></i> {{Fin}}</a></li>
			</ul>
		</div>
	</div>

	<div class="col-lg-10" id="div_jeeasyConfigureJeedom">
		<a class="btn btn-sm btn-success pull-left bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a>
		<a class="btn btn-sm btn-success pull-right bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a>
		<a class="btn btn-sm btn-default pull-right bt_jeeasyPrevious"><i class="fas fa-angle-double-left"></i> {{Précédent}}</a>
		<br/><br/>
<!--		<div class="jeeasyDisplay home">-->
<!--			<center><i class="fas fa-home" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Bienvenu sur l'assistant de configuration de votre}} --><?php //echo config::byKey('product_name'); ?><!--</div></center>-->
<!--			<center>{{Cliquez sur suivant pour commencer}}</center>-->
<!--			<br/>-->
<!--			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay main" style="display:none;">-->
<!--			<center><i class="fas fa-wrench" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons ici configurer les principaux paramètre de votre}} --><?php //echo config::byKey('product_name'); ?><!--</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<div class="form-group">-->
<!--						<label class="col-xs-4 control-label help" data-help="{{Nom de votre --><?php //echo config::byKey('product_name'); ?><!-- (utilisé notamment par le market)}}">{{Nom de votre}} --><?php //echo config::byKey('product_name'); ?><!--</label>-->
<!--						<div class="col-xs-4">-->
<!--							<input type="text" class="configKey form-control" data-l1key="name" />-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="form-group">-->
<!--						<label class="col-xs-4 control-label help" data-help="{{Langue de votre}} --><?php //echo config::byKey('product_name'); ?><!--">{{Langue}}</label>-->
<!--						<div class="col-xs-4">-->
<!--							<select class="configKey form-control" data-l1key="language">-->
<!--								<option value="fr_FR">French</option>-->
<!--								<option value="en_US">English</option>-->
<!--								<option value="de_DE">German</option>-->
<!--								<option value="es_ES">Spanish</option>-->
<!--								<option value="ru_RU">Russian</option>-->
<!--								<option value="id_ID">Indonesian</option>-->
<!--								<option value="it_IT">Italian</option>-->
<!--								<option value="ja_JP">Japanese</option>-->
<!--								<option value="pt_PT">Portuguese</option>-->
<!--								<option value="tr">Turkish</option>-->
<!--							</select>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="form-group">-->
<!--						<label class="col-xs-4 control-label help" data-help="{{Fuseau horaire de votre}} --><?php //echo config::byKey('product_name'); ?><!--">{{Date et heure}}</label>-->
<!--						<div class="col-xs-4">-->
<!--							<select class="configKey form-control" data-l1key="timezone">-->
<!--								<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>-->
<!--								<option value="Pacific/Tahiti">(GMT-10:00) Pacific/Tahiti</option>-->
<!--								<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>-->
<!--								<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>-->
<!--								<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>-->
<!--								<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>-->
<!--								<option value="America/Anchorage">(GMT-09:00) Alaska</option>-->
<!--								<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>-->
<!--								<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>-->
<!--								<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>-->
<!--								<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>-->
<!--								<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>-->
<!--								<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>-->
<!--								<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>-->
<!--								<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>-->
<!--								<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>-->
<!--								<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>-->
<!--								<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>-->
<!--								<option value="America/Havana">(GMT-05:00) Cuba</option>-->
<!--								<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>-->
<!--								<option value="America/Caracas">(GMT-04:30) Caracas</option>-->
<!--								<option value="America/Santiago">(GMT-04:00) Santiago</option>-->
<!--								<option value="America/La_Paz">(GMT-04:00) La Paz</option>-->
<!--								<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>-->
<!--								<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>-->
<!--								<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>-->
<!--								<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>-->
<!--								<option value="America/Guadeloupe">(GMT-04:00) Guadeloupe</option>-->
<!--								<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>-->
<!--								<option value="America/Araguaina">(GMT-03:00) UTC-3</option>-->
<!--								<option value="America/Montevideo">(GMT-03:00) Montevideo</option>-->
<!--								<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>-->
<!--								<option value="America/Godthab">(GMT-03:00) Greenland</option>-->
<!--								<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>-->
<!--								<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>-->
<!--								<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>-->
<!--								<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>-->
<!--								<option value="Atlantic/Azores">(GMT-01:00) Azores</option>-->
<!--								<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>-->
<!--								<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>-->
<!--								<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>-->
<!--								<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>-->
<!--								<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>-->
<!--								<option value="Africa/Casablanca">(GMT) Greenwich Mean Time : Casablanca</option>-->
<!--								<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>-->
<!--								<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>-->
<!--								<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>-->
<!--								<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>-->
<!--								<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>-->
<!--								<option value="Asia/Beirut">(GMT+02:00) Beirut</option>-->
<!--								<option value="Africa/Cairo">(GMT+02:00) Cairo</option>-->
<!--								<option value="Asia/Gaza">(GMT+02:00) Gaza</option>-->
<!--								<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>-->
<!--								<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>-->
<!--								<option value="Europe/Minsk">(GMT+02:00) Minsk</option>-->
<!--								<option value="Asia/Damascus">(GMT+02:00) Syria</option>-->
<!--								<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>-->
<!--								<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>-->
<!--								<option value="Asia/Tehran">(GMT+03:30) Tehran</option>-->
<!--								<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>-->
<!--								<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>-->
<!--								<option value="Asia/Kabul">(GMT+04:30) Kabul</option>-->
<!--								<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>-->
<!--								<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>-->
<!--								<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>-->
<!--								<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>-->
<!--								<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>-->
<!--								<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>-->
<!--								<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>-->
<!--								<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>-->
<!--								<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>-->
<!--								<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>-->
<!--								<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>-->
<!--								<option value="Australia/Perth">(GMT+08:00) Perth</option>-->
<!--								<option value="Australia/Eucla">(GMT+08:45) Eucla</option>-->
<!--								<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>-->
<!--								<option value="Asia/Seoul">(GMT+09:00) Seoul</option>-->
<!--								<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>-->
<!--								<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>-->
<!--								<option value="Australia/Darwin">(GMT+09:30) Darwin</option>-->
<!--								<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>-->
<!--								<option value="Australia/Hobart">(GMT+10:00) Hobart</option>-->
<!--								<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>-->
<!--								<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>-->
<!--								<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>-->
<!--								<option value="Asia/Magadan">(GMT+11:00) Magadan</option>-->
<!--								<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>-->
<!--								<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>-->
<!--								<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>-->
<!--								<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>-->
<!--								<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>-->
<!--								<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>-->
<!--								<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>-->
<!--							</select>-->
<!--						</div>-->
<!--					</div>-->
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay network" style="display:none;">-->
<!--			<center><i class="fas fa-wifi" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons ici configurer le réseaux de votre}} --><?php //echo config::byKey('product_name'); ?><!--.{{La pluspart du temps la configuration par défaut est correcte et vous n'avez pas à la modifier}}</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<legend>{{Accès interne}}</legend>-->
<!--					<div class="form-group">-->
<!--						<label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 control-label">{{Protocole}}</label>-->
<!--						<div class="col-lg-8 col-md-9 col-sm-8 col-xs-6">-->
<!--							<div class="input-group">-->
<!--								<select class="configKey form-control" data-l1key="internalProtocol">-->
<!--									<option value="">{{Aucun}}</option>-->
<!--									<option value="http://">HTTP</option>-->
<!--									<option value="https://">HTTPS</option>-->
<!--								</select>-->
<!--								<span class="input-group-addon">://</span>-->
<!--								<input type="text" class="configKey form-control" data-l1key="internalAddr" />-->
<!--								<span class="input-group-addon">:</span>-->
<!--								<input type="number" class="configKey form-control" data-l1key="internalPort" />-->
<!--								<span class="input-group-addon">/</span>-->
<!--								<input type="text" class="configKey form-control" data-l1key="internalComplement" />-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</fieldset>-->
<!--			</form>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<legend>{{Accès externe}}</legend>-->
<!--					<div class="form-group">-->
<!--						<label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 control-label">{{Protocole}}</label>-->
<!--						<div class="col-lg-8 col-md-9 col-sm-8 col-xs-6">-->
<!--							<div class="input-group">-->
<!--								<select class="configKey form-control" data-l1key="externalProtocol">-->
<!--									<option value="">{{Aucun}}</option>-->
<!--									<option value="http://">HTTP</option>-->
<!--									<option value="https://">HTTPS</option>-->
<!--								</select>-->
<!--								<span class="input-group-addon">://</span>-->
<!--								<input type="text" class="configKey form-control" data-l1key="externalAddr" />-->
<!--								<span class="input-group-addon">:</span>-->
<!--								<input type="number" class="configKey form-control" data-l1key="externalPort" />-->
<!--								<span class="input-group-addon">/</span>-->
<!--								<input type="text" class="configKey form-control" data-l1key="externalComplement" />-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</fieldset>-->
<!--			</form>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					--><?php
//foreach ($repos as $key => $value) {
//	if (!isset($value['scope']['proxy']) || $value['scope']['proxy'] === false) {
//		continue;
//	}
//	if ($configs[$key . '::enable'] == 0) {
//		continue;
//	}
//	echo '<legend>{{DNS (proxy)}} ' . $value['name'] . '</legend>';
//	if ($configs['dns::token'] == '') {
//		echo '<div class="alert alert-warning">{{Attention : cette fonctionnalité n\'est pas disponible dans le service pack community (voir votre service pack sur votre page profil sur le market)}}</div>';
//		continue;
//	}
//	echo '<div class="form-group">';
//	echo '<label class="col-xs-4 control-label">{{Utiliser les DNS}} ' . config::byKey('product_name') . '</label>';
//	echo '<div class="col-xs-8">';
//	echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::allowDNS" />';
//	echo '</div>';
//	echo '</div>';
//	echo '<div class="form-group">';
//	echo '<label class="col-xs-4 control-label">{{Statut DNS}}</label>';
//	echo '<div class="col-xs-8">';
//	if ($configs['market::allowDNS'] == 1 && network::dns_run()) {
//		echo '<span class="label label-success" style="font-size : 1em;">{{Démarré : }} <a href="' . network::getNetworkAccess('external') . '" target="_blank" style="color:white;text-decoration: underline;">' . network::getNetworkAccess('external') . '</a></span>';
//	} else {
//		echo '<span class="label label-warning" title="{{Normal si vous n\'avez pas coché la case : Utiliser les DNS}} ' . config::byKey('product_name') . '">{{Arrêté}}</span>';
//	}
//	echo '</div>';
//	echo '</div>';
//	echo '<div class="form-group">';
//	echo '<label class="col-xs-4 control-label">{{Gestion}}</label>';
//	echo '<div class="col-xs-8">';
//	echo '<a class="btn btn-success" id="bt_restartDns"><i class=\'fas fa-play\'></i> {{(Re)démarrer}}</a> ';
//	echo '<a class="btn btn-danger" id="bt_haltDns"><i class=\'fas fa-stop\'></i> {{Arrêter}}</a>';
//	echo '</div>';
//	echo '</div>';
//}
//?>
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay log" style="display:none;">-->
<!--			<center><i class="far fa-file" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons ici configurer les logs de votre}} --><?php //echo config::byKey('product_name'); ?><!--</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<div class="form-group">-->
<!--						<label class="col-xs-4 control-label">{{Niveau de log par défaut}}</label>-->
<!--						<div class="col-xs-4">-->
<!--							<select class="configKey form-control" data-l1key="log::level">-->
<!--								<option value="100">{{Debug}}</option>-->
<!--								<option value="200">{{Info}}</option>-->
<!--								<option value="300">{{Warning}}</option>-->
<!--								<option value="400">{{Erreur}}</option>-->
<!--							</select>-->
<!--						</div>-->
<!--					</div>-->
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay eqLogic" style="display:none;">-->
<!--			<center><i class="icon divers-svg" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons ici configurer les logs de votre}} --><?php //echo config::byKey('product_name'); ?><!--</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<div class="form-group">-->
<!--						<label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 control-label">{{Seuil des piles}}</label>-->
<!--						<label class="col-lg-1 col-md-1 col-sm-1 col-xs-1 eqLogicAttr label label-danger" style="font-size : 1.4em">{{Danger}}</label>-->
<!--						<div class="col-xs-1">-->
<!--							<input class="configKey form-control" data-l1key="battery::danger" />-->
<!--						</div>-->
<!--						<label class="col-xs-1 label label-warning" style="font-size : 1.4em">{{Warning}}</label>-->
<!--						<div class="col-xs-1">-->
<!--							<input class="configKey form-control" data-l1key="battery::warning" />-->
<!--						</div>-->
<!--						<label class="col-xs-1 label label-success" style="font-size : 1.4em">{{Ok}}</label>-->
<!--					</div>-->
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay market" style="display:none;">-->
<!--			<center><i class="far fa-credit-card" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons ici configurer la connexion de votre }} --><?php //echo config::byKey('product_name'); ?><!-- {{au market}}</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					--><?php
//foreach ($repos as $key => $value) {
//	if ($key != 'market') {
//		continue;
//	}
//	$active = ($key == 'market') ? 'active' : '';
//	echo '<div role="tabpanel" class="tab-pane ' . $active . '" id="tab' . $key . '">';
//	echo '<br/>';
//	echo '<div class="form-group">';
//	echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Activer}} ' . $value['name'] . '</label>';
//	echo '<div class="col-sm-1">';
//	echo '<input type="checkbox" class="configKey enableRepository" data-repo="' . $key . '" data-l1key="' . $key . '::enable"/>';
//	echo '</div>';
//	echo '</div>';
//	if ($value['scope']['hasConfiguration'] === false) {
//		echo '</div>';
//		continue;
//	}
//	echo '<div class="repositoryConfiguration' . $key . '">';
//	foreach ($value['configuration']['configuration'] as $pKey => $parameter) {
//		echo '<div class="form-group">';
//		echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">';
//		echo $parameter['name'];
//		echo '</label>';
//		echo '<div class="col-sm-6">';
//		$default = (isset($parameter['default'])) ? $parameter['default'] : '';
//		switch ($parameter['type']) {
//			case 'checkbox':
//				echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//				break;
//			case 'input':
//				echo '<input class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//				break;
//			case 'number':
//				echo '<input type="number" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//				break;
//			case 'password':
//				echo '<input type="password" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//				break;
//			case 'select':
//				echo '<select class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '">';
//				foreach ($parameter['values'] as $optkey => $optval) {
//					echo '<option value="' . $optkey . '">' . $optval . '</option>';
//				}
//				echo '</select>';
//				break;
//		}
//		echo '</div>';
//		echo '</div>';
//	}
//	if (isset($value['scope']['test']) && $value['scope']['test']) {
//		echo '<div class="form-group">';
//		echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Tester}}</label>';
//		echo '<div class="col-sm-4">';
//		echo '<a class="btn btn-default testRepoConnection" data-repo="' . $key . '"><i class="fas fa-check"></i> {{Tester}}</a>';
//		echo '</div>';
//		echo '</div>';
//	}
//	echo '</div>';
//	echo '</div>';
//}
//?>
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->

<!--		<div class="jeeasyDisplay alerts" style="display:none;">-->
<!--			<center><i class="fas fa-bell" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-info">{{Nous allons voir ici comment votre}} --><?php //echo config::byKey('product_name'); ?><!-- {{peut vous contacter}}</div></center>-->
<!--			<form class="form-horizontal">-->
<!--				<fieldset>-->
<!--					<legend>{{Alertes}}</legend>-->
<!--					<div class="form-group">-->
<!--						<label class="col-xs-3 control-label">{{Action sur message}}</label>-->
<!--						<div class="col-xs-4">-->
<!--							<a class="btn btn-success" id="bt_addActionOnMessage"><i class="fas fa-plus-circle"></i> {{Ajouter}}</a>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div id="div_actionOnMessage"></div>-->
<!--					<hr/>-->
<!--					--><?php
//foreach ($JEEDOM_INTERNAL_CONFIG['alerts'] as $level => $value) {
//	if (!in_array($level, array('timeout', 'batterydanger', 'danger'))) {
//		continue;
//	}
//	echo '<div class="form-group">';
//	echo '<label class="col-xs-3 control-label">{{Commande sur}} ' . $value['name'] . '</label>';
//	echo '<div class="col-xs-4">';
//	echo '<div class="input-group">';
//	echo '<input type="text"  class="configKey form-control" data-l1key="alert::' . $level . 'Cmd" />';
//	echo '<span class="input-group-btn">';
//	echo '<a class="btn btn-default cursor bt_selectAlertCmd" title="Rechercher une commande" data-type="' . $level . '"><i class="fas fa-list-alt"></i></a>';
//	echo '</span>';
//	echo '</div>';
//	echo '</div>';
//	echo '</div>';
//}
//?>
<!--				</fieldset>-->
<!--			</form>-->
<!--		</div>-->
<!---->
<!--		<div class="jeeasyDisplay end" style="display:none;">-->
<!--			<center><i class="fas fa-check" style="font-size: 10em;"></i></center>-->
<!--			<br/>-->
<!--			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini de configurer votre}} --><?php //echo config::byKey('product_name'); ?><!--</div></center>-->
<!--			<center>{{Cliquez sur sauvegarder pour valider votre configuration}}</center>-->
<!--			<br/>-->
<!--			<center><a class="btn btn-success bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a></center>-->
<!--		</div>-->
<!---->
<!--	</div>-->
<!--</div>-->

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

	$('.bt_selectAlertCmd').off('click').on('click', function () {
		var type=$(this).attr('data-type');
		jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'message'}}, function (result) {
			$('.configKey[data-l1key="alert::'+type+'Cmd"]').value(result.human);
		});
	});

	$("body").delegate(".listCmdAction", 'click', function () {
		var el = $(this).closest('.actionOnMessage').find('.expressionAttr[data-l1key=cmd]');
		jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) {
			el.value(result.human);
			jeedom.cmd.displayActionOption(el.value(), '', function (html) {
				el.closest('.actionOnMessage').find('.actionOptions').html(html);
				taAutosize();
			});
		});
	});

	$("body").delegate(".listAction", 'click', function () {
		var el = $(this).closest('.actionOnMessage').find('.expressionAttr[data-l1key=cmd]');
		jeedom.getSelectActionModal({}, function (result) {
			el.value(result.human);
			jeedom.cmd.displayActionOption(el.value(), '', function (html) {
				el.closest('.actionOnMessage').find('.actionOptions').html(html);
				taAutosize();
			});
		});
	});

	$("body").delegate('.bt_removeAction', 'click', function () {
		$(this).closest('.actionOnMessage').remove();
	});

	$('#bt_addActionOnMessage').on('click',function(){
		addActionOnMessage();
	});

	$('.bt_jeeasySave').off('click').on('click',function(){
		var config = $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0];
		jeedom.config.save({
			configuration: config,
			error: function (error) {
				$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				jeedom.config.load({
					configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
					error: function (error) {
						$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
						loadAactionOnMessage()
						modifyWithoutSave = false;
						$('#div_AlertJeeasyJeedomConfigure').showAlert({message: '{{Sauvegarde réussie}}', level: 'success'});
					}
				});
			}
		});
	});

	jeedom.config.load({
		configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
		error: function (error) {
			$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
		},
		success: function (data) {
			$('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
			loadAactionOnMessage();
			modifyWithoutSave = false;
		}
	});

	$('.testRepoConnection').on('click',function(){
		var repo = $(this).attr('data-repo');
		jeedom.config.save({
			configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
			error: function (error) {
				$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				jeedom.config.load({
					configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
					error: function (error) {
						$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
						modifyWithoutSave = false;
						jeedom.repo.test({
							repo: repo,
							error: function (error) {
								$('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
							},
							success: function (data) {
								$('#div_AlertJeeasyJeedomConfigure').showAlert({message: '{{Test réussi}}', level: 'success'});
							}
						});
					}
				});
			}
		});
	});

	function loadAactionOnMessage(){
		$('#div_actionOnMessage').empty();
		jeedom.config.load({
			configuration: 'actionOnMessage',
			error: function (error) {
				$('#div_alert').showAlert({message: error.message, level: 'danger'});
			},
			success: function (data) {
				if(data == ''){
					return;
				}
				actionOptions = [];
				for (var i in data) {
					addActionOnMessage(data[i]);
				}
				jeedom.cmd.displayActionsOption({
					params : actionOptions,
					async : false,
					error: function (error) {
						$('#div_alert').showAlert({message: error.message, level: 'danger'});
					},
					success : function(data){
						for(var i in data){
							$('#'+data[i].id).append(data[i].html.html);
						}
						taAutosize();
					}
				});
			}
		});
	}

	function addActionOnMessage(_action) {
		if (!isset(_action)) {
			_action = {};
		}
		if (!isset(_action.options)) {
			_action.options = {};
		}
		var div = '<div class="actionOnMessage">';
		div += '<div class="form-group ">';
		div += '<label class="col-xs-3 control-label">Action</label>';
		div += '<input type="checkbox" class="expressionAttr" data-l1key="options" data-l2key="enable" checked title="{{Décocher pour désactiver l\'action}}" style="display:none;" />';
		div += '<div class="col-xs-4">';
		div += '<div class="input-group">';
		div += '<span class="input-group-btn">';
		div += '<a class="btn btn-default bt_removeAction btn-sm"><i class="fas fa-minus-circle"></i></a>';
		div += '</span>';
		div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" />';
		div += '<span class="input-group-btn">';
		div += '<a class="btn btn-default btn-sm listAction" title="{{Sélectionner un mot-clé}}"><i class="fas fa-tasks"></i></a>';
		div += '<a class="btn btn-default btn-sm listCmdAction"><i class="fas fa-list-alt"></i></a>';
		div += '</span>';
		div += '</div>';
		div += '</div>';
		var actionOption_id = uniqId();
		div += '<div class="col-xs-5 actionOptions" id="'+actionOption_id+'">';
		div += '</div>';
		div += '</div>';
		$('#div_actionOnMessage').append(div);
		$('#div_actionOnMessage .actionOnMessage:last').setValues(_action, '.expressionAttr');
		actionOptions.push({
			expression : init(_action.cmd, ''),
			options : _action.options,
			id : actionOption_id
		});
	}
</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
