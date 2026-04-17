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

/* * ***************************Includes********************************* */
require_once __DIR__ . '/../../../../core/php/core.inc.php';
include_file('core', 'discover', 'config', 'jeeasy');

class jeeasy extends eqLogic {

	public static function getPluginDetails($_marketId = null) {
		$marketURL = config::byKey('market::address');
		$pluginDetails = array(
			26 => [
				'logicalId' => 'alarm',
				'name' => __('Alarme', __FILE__),
				'category' => '<i class="fas fa-lock"></i> ' . __('Sécurité', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/alarm_icon.png',
				'description' => __("Créez facilement votre système d'alarme sur mesure", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../alarm/plugin_info/info.json')
			],
			52 => [
				'logicalId' => 'rfxcom',
				'name' => __('RFXcom', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/rfxcom_icon.png',
				'description' => __("Pilotez vos périphériques RFXcom", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../rfxcom/plugin_info/info.json')
			],
			203 => [
				'logicalId' => 'eibd',
				'name' => __('EIB - KNX', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/eibd_icon.png',
				'description' => __("Pilotez vos périphériques KNX", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../eibd/plugin_info/info.json')
			],
			1666 => [
				'logicalId' => 'Freebox_OS',
				'name' => __('Freebox OS', __FILE__),
				'category' => '<i class="fas fa-tachometer-alt"></i> ' . __('Monitoring', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/Freebox_OS_icon.png',
				'description' => __("Prenez le contrôle de votre Freebox", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../Freebox_OS/plugin_info/info.json')
			],
			2030 => [
				'logicalId' => 'mobile',
				'name' => __('Mobile', __FILE__),
				'category' => '<i class="fas fa-comment"></i> ' . __('Communication', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/mobile_icon.png',
				'description' => __("Pilotez votre installation domotique depuis iOS/Android", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../mobile/plugin_info/info.json')
			],
			2046 => [
				'logicalId' => 'ipx800v4',
				'name' => __('IPX 800 v4', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/ipx800v4_icon.png',
				'description' => __("Pilotez vos périphériques IPX 800", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../ipx800v4/plugin_info/info.json')
			],
			// 2286 => [
			// 	'logicalId' => 'wifip',
			// 	'name' => __('Wifip', __FILE__),
			// 	'category' => '<i class="fas fa-comment"></i> ' . __('Communication', __FILE__),
			// 	'icon' => $marketURL . '/filestore/market/plugin/images/wifip_icon.png',
			// 'description' => '',
			// 	'installed' => is_file(__DIR__ . '/../../../wifip/plugin_info/info.json')
			// ],
			2622 => [
				'logicalId' => 'openenocean',
				'name' => __('EnOcean', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/openenocean_icon.png',
				'description' => __("Pilotez vos périphériques Enocean", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../openenocean/plugin_info/info.json')
			],
			// 2781 => [
			// 	'logicalId' => 'rfplayer',
			// 	'name' => __('Ziblue RfPlayer', __FILE__),
			// 	'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
			// 	'icon' => $marketURL . '/filestore/market/plugin/images/rfplayer_icon.png',
			// 'description' => '',
			// 	'installed' => is_file(__DIR__ . '/../../../rfplayer/plugin_info/info.json')
			// ],
			3349 => [
				'logicalId' => 'rfplayer2',
				'name' => __('RfPlayer2', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/rfplayer2_icon.png',
				'description' => __("Pilotez vos périphériques RF Player", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../rfplayer2/plugin_info/info.json')
			],
			3610 => [
				'logicalId' => 'deconz',
				'name' => __('Deconz', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/deconz_icon.png',
				'description' => __("Pilotez vos périphériques Deconz", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../deconz/plugin_info/info.json')
			],
			3895 => [
				'logicalId' => 'ventilairsec',
				'name' => __('Ventilairsec', __FILE__),
				'category' => '<i class="fas fa-tachometer-alt"></i> ' . __('Monitoring', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/ventilairsec_icon.png',
				'description' => __("Liez votre VMI du groupe Ventilairsec avec l'application VMI Link", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../ventilairsec/plugin_info/info.json')
			],
			// 4050 => [
			// 	'logicalId' => 'zigbee',
			// 	'name' => __('Zigbee', __FILE__),
			// 	'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
			// 	'icon' => $marketURL . '/filestore/market/plugin/images/zigbee_icon.png',
			// 'description' => ',
			// 	'installed' => is_file(__DIR__ . '/../../../zigbee/plugin_info/info.json')
			// ],
			4146 => [
				'logicalId' => 'lorapayload',
				'name' => __('Lora Payload', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/lorapayload_icon.png',
				'description' => __("Pilotez vos périphériques Lora", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../lorapayload/plugin_info/info.json')
			],
			4195 => [
				'logicalId' => 'atlas',
				'name' => __('Atlas', __FILE__),
				'category' => '<i class="fas fa-asterisk"></i> ' . __('Passerelle domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/atlas_icon.png',
				'description' => __("Prenez le contrôle de votre Atlas", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../atlas/plugin_info/info.json')
			],
			4306 => [
				'logicalId' => 'zwavejs',
				'name' => __('Z-Wave JS', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/zwavejs_icon.png',
				'description' => __("Pilotez vos périphériques Z-Wave", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../zwavejs/plugin_info/info.json')
			],
			4346 => [
				'logicalId' => 'luna',
				'name' => __('Luna', __FILE__),
				'category' => '<i class="fas fa-asterisk"></i> ' . __('Passerelle domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/luna_icon.png',
				'description' => __("Prenez le contrôle de votre Luna", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../luna/plugin_info/info.json')
			],
			4351 => [
				'logicalId' => 'z2m',
				'name' => __('JeeZigbee', __FILE__),
				'category' => '<i class="fas fa-rss"></i> ' . __('Protocole domotique', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/z2m_icon.png',
				'description' => __("Pilotez vos périphériques Zigbee", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../z2m/plugin_info/info.json')
			],
			4408 => [
				'logicalId' => 'lns',
				'name' => __('LNS', __FILE__),
				'category' => __('Programmation', __FILE__),
				'icon' => $marketURL . '/filestore/market/plugin/images/lns_icon.png',
				'description' => __("Installez et configurez automatiquement Chirpstack V3", __FILE__),
				'installed' => is_file(__DIR__ . '/../../../lns/plugin_info/info.json')
			]
		);
		if (!$_marketId) {
			return $pluginDetails;
		}
		if (isset($pluginDetails[$_marketId])) {
			return $pluginDetails[$_marketId];
		}
		return false;
	}

	public static function getWizardSteps($_mode = 'default'): array {
		$wizard['welcome'] =  __('Accueil', __FILE__);
		update::checkAllUpdate();
		if (update::nbNeedUpdate() > 0) {
			$wizard['updates'] =	__('Mises à jour', __FILE__);
		}
		if (in_array($hardware = strtolower(jeedom::getHardwareName()), ['atlas', 'luna', 'freeboxdelta'])) {
			if (strpos($hardware, 'freebox') !== false) {
				$hardware = 'freebox_OS';
			}
			if (!is_object(update::byLogicalId($hardware))) {
				$wizard[$hardware] =	ucfirst($hardware);
			}
		}
		$wizard['general'] =	__('Général', __FILE__);
		$wizard['interface'] =	__('Interface', __FILE__);
		$wizard['networks'] =	__('Réseaux', __FILE__);
		$wizard['plugins'] =	__('Plugins', __FILE__);
		$wizard['objects'] =	__('Objets', __FILE__);
		if ($_mode != 'mb') {
			$wizard['services'] =	__('Services', __FILE__);
		}
		$wizard['ready'] = __('Prêt à démarrer', __FILE__);
		return $wizard;
	}

	public static function getWizardMode(): string {
		if (config::byKey('mbState', 'core', 0) == 1) {
			return 'mb';
		}
		return 'default';
	}

	public static function updateServicePackInfos() {
		$servicePack = 'Community';
		$plugins = array();
		$jsonrpc = repo_market::getJsonRpc();
		if ($jsonrpc->sendRequest('servicepack::info')) {
			$result = $jsonrpc->getResult();
			$servicePack = $result['licenceName'];
			if ($servicePack != 'Community') {
				if (is_array($result['licencePlugins'])) {
					$plugins = $result['licencePlugins'];
				}
				$plugins = array_merge($plugins, $result['mainPlugins']);
			}
			config::save('SPInfos', array('servicePack' => $servicePack, 'plugins' => $plugins), __CLASS__);
			return array('servicePack' => $servicePack, 'plugins' => $plugins);
		}
		return false;
	}

	public static function cronDaily() {
		self::updateServicePackInfos();
	}

	public static function discoverNetwork() {
		global $JEEDOM_JEEASY_DISCOVER;
		$gw = shell_exec("ip route show default | awk '/default/ {print $3}'");
		if ($gw == '') {
			return array();
		}
		$ip = explode('.', $gw);
		$results = explode("\n", shell_exec('sudo nmap -sn ' . $ip[0] . '.' . $ip[1] . '.' . $ip[2] . '.* | grep -E "MAC Address|Nmap scan report"'));

		$return = array();
		$arrayFinal = array();
		$previous = null;
		$i = 1;
		foreach ($results as $line) {
			$arrayTemp = array();
			if (strpos($line, 'Nmap scan report') !== false) {
				preg_match('/Nmap scan report for (.*?)$/', $line, $matches);
				$previous = $matches[1];
			}
			if ($previous == null) {
				continue;
			}
			if (strpos($line, 'MAC Address') !== false) {
				$name = substr($line, ($p = strpos($line, '(') + 1), strrpos($line, ')') - $p);
				preg_match('/MAC Address: (.*?) \((.*?)\)/', $line, $matches);
				$return[$matches[1]] = array('name' => $matches[2], 'ip' => $previous);
				//	$name = $matches[2];
				$mac = $matches[1];
				$ip = $previous;
				$arrayTemp = array('mac' => $mac, 'ip' => $ip);



				if (array_key_exists($name, $arrayFinal)) {
					array_push($arrayFinal[$name], $arrayTemp);

					$i++;
				} else {
					$arrayFinal[$name] = $arrayTemp;
				}
			}
		}


		foreach ($arrayFinal as &$device) {

			foreach ($JEEDOM_JEEASY_DISCOVER as $discover) {

				foreach ($discover['search'] as $search) {
					if (strpos(strtolower($device['name']), strtolower($search)) !== false || strpos(strtolower($device['ip']), strtolower($search)) !== false) {
						$device['plugin'] = $discover['plugins'];
						continue (3);
					}
				}
			}
		}
		return $arrayFinal;
	}

	public static function generateScenario($_name, $_replace = array()) {
		if (!file_exists(__DIR__ . '/../config/' . $_name . '.json')) {
			throw new Exception(__('Impossible de trouver le scénario', __FILE__) . ' : ' . $_name);
		}
		return json_decode(str_replace(array_keys($_replace), $_replace, json_encode(json_decode(file_get_contents(__DIR__ . '/../config/' . $_name . '.json'), true))), true);
	}

	public static function initStartBox() {
		log::removeAll();
		log::add('jeeasy', 'debug', 'initStartBox');
		if (config::byKey('jeedom::firstUse') == 1) {
			config::save('api', config::genKey());
			config::save('apimarket', config::genKey());
			config::save('apipro', config::genKey());
			config::save('apitts', config::genKey());
		}
		message::removeAll();
		repo_market::test();
	}
}

class jeeasyCmd extends cmd {

	public function execute($_options = array()) {
	}
}
