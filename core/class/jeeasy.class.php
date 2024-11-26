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
			$wizard['pluginsInstall'] =	__('Installation plugins', __FILE__);
		} else {
			$wizard['general'] =	__('Général', __FILE__);
			$wizard['interface'] =	__('Affichage', __FILE__);
			$wizard['objects'] =	__('Objets', __FILE__);
			if ($_mode == 'default') {
				$wizard['pluginsInstall'] =	__('Installation plugins', __FILE__);
			}
			$wizard['pluginsConfig'] =	__('Configuration plugins', __FILE__);
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

	public static function checkPlugin($_plugin) {
		if ($_plugin == 'openvpn') {
			$plugin = $_plugin;
		} else {
			$plugin = plugin::byId($_plugin);
		}

		if (!is_object($plugin)) {
			$plugin = $_plugin;
		}
		if (config::byKey('core::branch') == 'beta' || config::byKey('core::branch') == 'alpha') {
			self::checkInstallPlugin($plugin, 'beta');
		} else {
			self::checkInstallPlugin($plugin);
		}
		self::checkDependancyPlugin($plugin);
		self::checkDeamonPlugin($plugin);
	}

	public static function checkInstallPlugin($_plugin, $branch = 'stable') {
		$plugin = !is_object($_plugin) ? $_plugin : plugin::byId($_plugin);
		if (is_object($plugin) && $plugin->isActive()) {
			return 'OK';
		}
		$market_info = repo_market::byLogicalId($_plugin);
		if (!is_object($market_info)) {
			return __('Le plugin n\'est pas présent sur le market', __FILE__);
		}
		if ($market_info->getCost() > 0) {
			if ($market_info->getPurchase() != 1) {
				return __('Veuillez vous rendre sur le market pour acquérir le plugin puis refaire l\'opération. Plugin', __FILE__) . ' : ' . $market_info->getName();
			}
		}

		$update = update::byLogicalId($_plugin);
		if (!is_object($update)) {
			$update = new update();
		}
		$update->setLogicalId($_plugin);
		$update->setSource('market');
		$update->setConfiguration('version', $branch);
		$update->save();
		$update->doUpdate();
		$plugin = plugin::byId($_plugin);
		if (!is_object($plugin)) {
			return __('Impossible d\'installer le plugin', __FILE__) . ' : ' . $market_info->getName();
		}
		if (!$plugin->isActive()) {
			$plugin->setIsEnable(1);
		}
		if (!$plugin->isActive()) {
			return __('Impossible d\'activer le plugin', __FILE__) . ' : ' . $market_info->getName();
		}
		return 'OK';
	}

	public static function checkDependancyPlugin($_plugin) {
		$plugin = is_object($_plugin) ? $_plugin : plugin::byId($_plugin);
		if ($plugin->getHasDependency() != 1) {
			return 'OK';
		}
		$dependancy = $plugin->dependancy_info();
		if ($dependancy['state'] == 'ok') {
			return 'OK';
		}

		$plugin->dependancy_install();
		$dependancy = $plugin->dependancy_info();
		if ($dependancy['state'] != 'ok') {
			return __('Nous n\'arrivons pas à installer les dépendances du plugin. Nous vous conseillons de consulter les logs et/ou de contacter le support.', __FILE__);
		}
		return 'OK';
	}

	public static function configInternalPlugin($typeConfig, $key, $plugin) {
		if ($typeConfig == 'gpio') {
			$pluginConfigFile = dirname(__FILE__) . '/../data/pluginConfig.json';
			if (!file_exists($pluginConfigFile)) {
				throw new Exception("{{Fichier pluginConfig introuvable}}", 1);
			}
			$pluginConfigFile = file_get_contents($pluginConfigFile);
			$pluginsConf = json_decode($pluginConfigFile, true);
			$step = $pluginsConf['pluginsInfos'][$plugin]['versions'][$key];

			foreach ($step as $k => $v) {
				config::save($k, $v, $plugin);
			}
			return 'gpio';
		} elseif ($typeConfig == 'usb') {
			return 'usb';
		}
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

	public static function checkDeamonPlugin($_plugin) {
		$plugin = is_object($_plugin) ? $_plugin : plugin::byId($_plugin);
		if ($plugin->getHasOwnDeamon() != 1) {
			return;
		}
		$deamon = $plugin->deamon_info();
		if ($deamon['state'] == 'ok') {
			return;
		}
		echo '<div class="alert alert-info">' . __('Nous avons détecté que le démon ne tourne pas, nous allons essayer de le démarrer. Merci de patienter...', __FILE__);
		$plugin->deamon_start();
		sleep(5);
		$deamon = $plugin->deamon_info();
		if ($deamon['state'] != 'ok') {
			throw new Exception(__('Nous n\'arrivons pas à démarrer le démon du plugin. Nous vous conseillons de consulter les logs et/ou de contacter le support. Plugin', __FILE__) . ' : ' . $_plugin);
		}
		echo '<div class="alert alert-info">' . __('Démarrage du démon réussi', __FILE__);
	}
}

class jeeasyCmd extends cmd {

	public function execute($_options = array()) {
	}
}
