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

	if (init('action') == 'getMarketPluginsList') {
		$SPInfos = config::byKey('SPInfos', 'jeeasy');
		if ($SPInfos == '' && !($SPInfos = jeeasy::updateServicePackInfos())) {
			throw new Exception(__('La récupération des informations depuis le Market a échoué', __FILE__) . ' : ' . init('action'));
		}
		$jsonrpc = repo_market::getJsonRpc();
		$marketURL = config::byKey('market::address');
		$plugins = (array) $SPInfos['plugins'];
		foreach ($plugins as $i => $pluginId) {
			unset($plugins[$i]);
			if ($pluginId == 'official' || $pluginId == 2286 /*wifip*/) {
				continue;
			}

			if ($jsonrpc->sendRequest('market::byId', ['id' => $pluginId])) {
				$result = $jsonrpc->getResult();
				$plugins[$i]['id'] = $pluginId;
				$plugins[$i]['logicalId'] = $result['logicalId'];
				$plugins[$i]['name'] = $result['name'];
				$plugins[$i]['icon'] = $marketURL . '/' . $result['img']['icon'];
				$plugins[$i]['installed'] = is_file(__DIR__ . '/../../../' . $result['logicalId'] . '/plugin_info/info.json');
			}
		}
		ajax::success(array('servicePack' => $SPInfos['servicePack'], 'plugins' => $plugins));
	}

	throw new Exception(__('Aucune méthode correspondante à', __FILE__) . ' : ' . init('action'));
} catch (Exception $e) {
	ajax::error(displayException($e), $e->getCode());
}
