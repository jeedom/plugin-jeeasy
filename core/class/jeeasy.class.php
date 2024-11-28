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

	public static function getWizardSteps($_mode = 'default'): array {
		$wizard['welcome'] =  __('Accueil', __FILE__);

		if ($_mode == 'recovery') {
			$wizard['pluginsInstall'] =	__('Plugins', __FILE__);
		} else {
			$wizard['general'] =	__('Général', __FILE__);
			$wizard['interface'] =	__('Affichage', __FILE__);
			$wizard['objects'] =	__('Objets', __FILE__);
			$wizard['plugins'] =	__('Plugins', __FILE__);
			$wizard['dns'] =	__('Accès externe', __FILE__);
			if ($_mode == 'default') {
				$wizard['services'] =	__('Services', __FILE__);
				// $wizard['backupCloud'] =	__('Sauvegarde Cloud', __FILE__);
				// $wizard['assistants'] =	__('Assistants vocaux', __FILE__);
			}
		}
		$wizard['ready'] = __('Prêt à démarrer', __FILE__);
		return $wizard;
	}

	public static function getWizardMode(): string {
		if (strtolower(trim(gethostname())) == 'jeedomatlasrecovery') {
			return 'recovery';
		} else if (config::byKey('mbState', 'core', 0) == 1) {
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

	public static function dns_Go() {
		repo_market::test();
		try {
			jeeasy::checkPlugin('openvpn');
			sleep(10);
			config::save('market::allowDNS', 1);
			network::dns_start();
		} catch (Exception $e) {
			log::add('jeeasy', 'debug', 'erreur DNS > ' . $e);
		}
		sleep(2);
		repo_market::test();
	}
}

class jeeasyCmd extends cmd {

	public function execute($_options = array()) {
	}
}
