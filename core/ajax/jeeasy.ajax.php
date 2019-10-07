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

try {
	require_once __DIR__ . '/../../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');

	ajax::init();

	if (init('action') == 'generateScenario') {
		ajax::success(jeeasy::generateScenario(init('name'), json_decode(init('replace'), true)));
	}

	if (init('action') == 'saveJson') {
		ajax::success(jeeasy::saveJson(init('json')));
	}

	if (init('action') == 'sendObjects') {
		ajax::success(jeeasy::sendObjects(init('objects')));
	}
	
	if (init('action') == 'installPlugin') {
		$repo = repo_market::byLogicalIdAndType(init(id), 'plugin');
		if (!is_object($repo)) {
			throw new Exception(__('Impossible de trouver l\'objet associé : ', __FILE__) . init(id));
		}
		$update = update::byTypeAndLogicalId($repo->getType(), $repo->getLogicalId());
		if (!is_object($update)) {
			$update = new update();
		}
		$update->setSource('market');
		$update->setLogicalId($repo->getLogicalId());
		$update->setType($repo->getType());
		$update->setLocalVersion($repo->getDatetime(init('version', 'stable')));
		$update->setConfiguration('version', init('version', 'stable'));
		$update->save();
		$update->doUpdate();
		
		$pluginInstall = plugin::byId('Freebox_OS');
		if(is_object($pluginInstall)){
			$pluginInstall->setIsEnable(1);
			$pluginInstall->dependancy_install();
			$pluginInstall->deamon_start();
			ajax::success();
		}
		ajax::error();
	}

	throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
	/*     * *********Catch exeption*************** */
} catch (Exception $e) {
	ajax::error(displayExeption($e), $e->getCode());
}
