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

class jeeasy extends eqLogic {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	public static function generateScenario($_name, $_replace = array()) {
		if (!file_exists(__DIR__ . '/../config/' . $_name . '.json')) {
			throw new Exception(__('Impossible de trouver le scénario : ', __FILE__) . $_name);
		}
		return json_decode(str_replace(array_keys($_replace), $_replace, json_encode(json_decode(file_get_contents(__DIR__ . '/../config/' . $_name . '.json'), true))), true);
	}

	public static function saveJson($_json) {
		$jsonFile = __DIR__ . '/../../../../data/custom/wizard.json';
		if (!$fh = fopen($jsonFile, 'w')) {
			throw new Exception(__('Impossible d ouvrir : ', __FILE__) . $jsonFile);
		}
		fwrite($fh, $_json);
		fclose($fh);
		return true;
	}

	public static function checkPlugin($_plugin) {
		$plugin = plugin::byId($_plugin);
		if (!is_object($plugin)) {
			$plugin = $_plugin;
		}
		self::checkInstallPlugin($_plugin);
		self::checkDependancyPlugin($plugin);
		self::checkDeamonPlugin($plugin);
	}

	public static function checkInstallPlugin($_plugin) {
		$plugin = is_object($_plugin) ? $_plugin : plugin::byId($_plugin);
		if (is_object($plugin) && $plugin->isActive()) {
			return;
		}
		echo '<div class="alert alert-info">' . __('Nous avons détecté que vous n\'avez pas le plugin pour gérer le protocole EnOcean, nous allons essayer de l\'installer', __FILE__);
		$market_info = repo_market::byLogicalId($_plugin);
		if ($market_info->getPurchase() !== 1) {
			throw new Exception(__('Vous n\'avez pas acheté le plugin en question, merci d\'aller sur le market d\'acheter le plugin et de refaire l\'opération, plugin : ', __FILE__) . $market_info->getName());
		}
		$update = update::byLogicalId($_plugin);
		if (!is_object($update)) {
			$update = new update();
		}
		$update->setLogicalId($_plugin);
		$update->setSource('market');
		$update->setConfiguration('version', 'stable');
		$update->save();
		$update->doUpdate();
		$plugin = plugin::byId($_plugin);
		if (!is_object($plugin)) {
			throw new Exception(__('Impossible d\'installer le plugin : ', __FILE__) . $_plugin);
		}
		if (!$plugin->isActive()) {
			$plugin->setIsEnable(1);
		}
		if (!$plugin->isActive()) {
			throw new Exception(__('Impossible d\'activer le plugin : ', __FILE__) . $_plugin);
		}
		echo '<div class="alert alert-info">' . __('Installation réussie !!!', __FILE__);
	}

	public static function checkDependancyPlugin($_plugin) {
		$plugin = is_object($_plugin) ? $_plugin : plugin::byId($_plugin);
		if ($plugin->getHasDependency() != 1) {
			return;
		}
		$dependancy = $plugin->dependancy_info();
		if ($dependancy['state'] == 'ok') {
			return;
		}
		echo '<div class="alert alert-info">' . __('Nous avons détecté que votre démon ne tourne pas, nous allons essayer de le lancer. Merci de patienter', __FILE__);
		$plugin->dependancy_install();
		$dependancy = $plugin->dependancy_info();
		if ($deamon['state'] != 'ok') {
			throw new Exception(__('Malheureusement nous n\'arrivons pas à installer les dépendances du plugin. Nous vous conseillons de regarder les logs et/ou de contacter le support. Plugin : ', __FILE__) . $_plugin);
		}
		echo '<div class="alert alert-info">' . __('Installation des dépendances réussies', __FILE__);
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
		echo '<div class="alert alert-info">' . __('Nous avons détecté que votre démon ne tourne pas, nous allons essayer de le lancer. Merci de patienter', __FILE__);
		$plugin->deamon_start();
		sleep(5);
		$deamon = $plugin->deamon_info();
		if ($deamon['state'] != 'ok') {
			throw new Exception(__('Malheureusement nous n\'arrivons pas à lancer le deamon du plugin. Nous vous conseillons de regarder les logs et/ou de contacter le support. Plugin : ', __FILE__) . $_plugin);
		}
		echo '<div class="alert alert-info">' . __('Lancement du démon réussi', __FILE__);
	}

	/*     * **********************Getteur Setteur*************************** */
}

class jeeasyCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	public function execute($_options = array()) {

	}

	/*     * **********************Getteur Setteur*************************** */
}
