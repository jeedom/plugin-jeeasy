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
				$name = substr($line, ($p = strpos($line, '(')+1), strrpos($line, ')')-$p);
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

	public static function changeLanguage($choice) {
		if ($choice != '') {
			config::save('language', $choice);
		}
	}

	public static function saveJson($_json) {
		$jsonFile = __DIR__ . '/../../../../data/custom/wizard.json';
		if (!$fh = fopen($jsonFile, 'w')) {
			throw new Exception(__('Impossible d\'ouvrir : ', __FILE__) . $jsonFile);
		}
		fwrite($fh, $_json);
		fclose($fh);
		return true;
	}

	public static function sendObjects($_objects) {

		$roomsDatas = array(
			'cuisine' => array(
				'level'  => 1,
				'name'   => 'Cuisine',
				'image'  => 'core/img/object_background/cuisine/cuisine_2.jpg',
				'icon'   => '<i class="icon maison-kitchen56"></i>',
				'parent' => ''
			),
			// 'bureau' => array(
			// 	'level'  => 1,
			// 	'name'   => 'Bureau',
			// 	'image'  => 'core/img/object_background/bureau/bureau_1.jpg',
			// 	'icon'   => ''
			// 	'parent' => ''
			// ),
			'sam' => array(
				'level'  => 1,
				'name'   => 'Salle à manger',
				'image'  => 'core/img/object_background/salle_a_manger/salle_a_manger_1.jpg',
				'icon'   => '<i class="icon maison-dining3"></i>',
				'parent' => ''
			),
			'salon' => array(
				'level'  => 1,
				'name'   => 'Salon',
				'image'  => 'core/img/object_background/salon/salon_2.jpg',
				'icon'   => '<i class="icon maison-sofa5"></i>',
				'parent' => ''
			),
			'sdb' => array(
				'level'  => 1,
				'name'   => 'Salle de bain',
				'image'  => 'core/img/object_background/salle_de_bain/salle_de_bain_1.jpg',
				'icon'   => '<i class="icon maison-bathroom22"></i>',
				'parent' => ''
			),
			'chambre1' => array(
				'level'  => 1,
				'name'   => 'Chambre 1',
				'image'  => 'core/img/object_background/chambre/chambre_1.jpg',
				'icon'   => '<i class="icon maison-queen9"></i>',
				'parent' => ''
			),
			'chambre2' => array(
				'level'  => 1,
				'name'   => 'Chambre 2',
				'image'  => 'core/img/object_background/chambre/chambre_3.jpg',
				'icon'   => '<i class="icon maison-queen9"></i>',
				'parent' => ''
			),
			'chambre3' => array(
				'level'  => 1,
				'name'   => 'Chambre 3',
				'image'  => 'core/img/object_background/chambre/chambre_4.jpg',
				'icon'   => '<i class="icon maison-baby139"></i>',
				'parent' => ''
			)
		);

		$houseData = array(
			'house' => array(
				'name'   => 'Maison',
				'image'  => 'core/img/object_background/salon/salon_5.jpg',
				'icon'   => '<i class="icon maison-modern13"></i>'
			),
			'apartment' => array(
				'name'   => 'Appartement',
				'image'  => 'core/img/object_background/cuisine/cuisine_1.jpg',
				'icon'   => '<i class="icon maison-building33"></i>'
			),
			'work' => array(
				'name'   => 'Travail',
				'image'  => 'core/img/object_background/bureau/bureau_1.jpg',
				'icon'   => '<i class="icon maison-man337"></i>'
			),                
			'basement' => array(
				'name'   => 'Batiment',
				'image'  => 'core/img/object_background/batiment/industrial_building.jpg',
				'icon'   => '<i class="icon far fa-building"></i>'
			)
			
		);

		$_objects = json_decode($_objects, true);

		preg_match('/\[([^]]+)\]/', $_objects[0], $key);
		$main = $key[1];
		$house = jeeObject::byName($houseData[$main]['name']);

		if (!is_object($house)) {
			//log::add('core', 'info', 'création box');
			$house = new jeeObject();
			$house->setName($houseData[$main]['name']);
			$house->setIsVisible(1);
			$house->setFather_id(0);
			$house->save();
			$house->setDisplay('icon', $houseData[$main]['icon']);
			$files = ls(__DIR__ . '/../../../../data/object/', 'object' . $house->getId() . '*');
			if (count($files)  > 0) {
				foreach ($files as $file) {
					unlink(__DIR__ . '/../../../../data/object/' . $file);
				}
			}
			$house->setImage('type', 'jpg');
			$image =  __DIR__ . '/../../../../' . $houseData[$main]['image'];
			$house->setImage('sha512', sha512(file_get_contents($image)));
			$filename = 'object' . $house->getId() . '-' . $house->getImage('sha512') . '.' . $house->getImage('type');
			$filepath = __DIR__ . '/../../../../data/object/' . $filename;
			file_put_contents($filepath, file_get_contents($image));
			$house->save();
		}

		$houseId = $house->getId();

		unset($_objects[0]);
		$structure = array();
		$structure[$main]['image'] = 'core/img/object_background//';
		$structure[$main]['icon'] = '';

		foreach ($_objects as $obj) {

			preg_match('/\[([^]]+)\]/', $obj, $regexRoom);
			$currentRoom = $regexRoom[1];

			$structure[$main]['rooms'][] = $roomsDatas[$currentRoom];

			$room = jeeObject::byName($roomsDatas[$currentRoom]['name']);

			if (!is_object($room)) {
				$room = new jeeObject();
				$room->setName($roomsDatas[$currentRoom]['name']);
				$room->setIsVisible(1);
				$room->setFather_id($houseId);
				$room->save();
				$room->setDisplay('icon', $roomsDatas[$currentRoom]['icon']);
				$files = ls(__DIR__ . '/../../../../data/object/', 'object' . $room->getId() . '*');
				if (count($files)  > 0) {
					foreach ($files as $file) {
						unlink(__DIR__ . '/../../../../data/object/' . $file);
					}
				}
				$room->setImage('type', 'jpg');
				$image =  __DIR__ . '/../../../../' . $roomsDatas[$currentRoom]['image'];
				$room->setImage('sha512', sha512(file_get_contents($image)));
				$filename = 'object' . $room->getId() . '-' . $room->getImage('sha512') . '.' . $room->getImage('type');
				$filepath = __DIR__ . '/../../../../data/object/' . $filename;
				file_put_contents($filepath, file_get_contents($image));
				$room->save();
			}
		}
		$json = json_encode($structure);
		//self::saveJson($json);
		return true;
	}

	public static function generateObject() {
		// $house = object::byName('box-' . $houseCode);
		//       if (!is_object($house)) {
		//           //log::add('core', 'info', 'création box');
		//           $house = new object();
		//           $house->setName('box-' . $houseCode);
		//           $house->setIsVisible(1);
		//           $house->setFather_id(0);
		//           $house->save();
		//       }
		//       $houseId = $house->getId();
		// //on parse toutes les lignes pour trouver le logement passé en paramètre
		// foreach ($Reader as $Row) {
		//     if ($Row[0] == $houseCode) {
		//         //list($cKey, $cValue) = explode('-', $Row[3], 2);
		//         $roomName = $Row[1];
		//         $room = object::byName('Chambre '.$roomName);
		//         if (!is_object($room)) {
		//             //log::add('core', 'info', 'création pièce ' . $roomName);
		//             $room = new object();
		//         }
		//         $room->setName('Chambre '.$roomName);
		//         $room->setIsVisible(1);
		//         $room->setFather_id($houseId);
		//         $room->save();
		//         $roomId = $room->getId();
	}

	public static function checkPlugin($_plugin) {
		if($_plugin == 'openvpn'){
		 $plugin = $_plugin;
		}else{
		  $plugin = plugin::byId($_plugin);
		}

		if (!is_object($plugin)) {
			$plugin = $_plugin;
		}
		if(config::byKey('core::branch') == 'beta' || config::byKey('core::branch') == 'alpha'){
        		self::checkInstallPlugin($plugin, 'beta');
        	}else{
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

	public static function initStartBox(){
		log::removeAll();
		log::add('jeeasy', 'debug', 'initStartBox');
		if(config::byKey('jeedom::firstUse') == 1){
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
		try{
        jeeasy::checkPlugin('openvpn');
		    sleep(10);
          	config::save('market::allowDNS',1);
		    network::dns_start();
		}catch (Exception $e) {
          log::add('jeeasy', 'debug', 'erreur DNS > '.$e);

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
