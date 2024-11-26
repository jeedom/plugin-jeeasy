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
		$servicePack = 'Community';
		$plugins = array();
		$marketURL = config::byKey('market::address');
		$jsonrpc = repo_market::getJsonRpc();
		if ($jsonrpc->sendRequest('servicepack::info')) {
			$result = $jsonrpc->getResult();
			$servicePack = $result['licenceName'];
			if ($servicePack != 'Community') {
				if (is_array($result['licencePlugins'])) {
					$plugins = $result['licencePlugins'];
				}
				$plugins = array_merge($plugins, $result['mainPlugins']);
				foreach ($plugins as $i => $pluginId) {
					unset($plugins[$i]);
					if ($pluginId == 'official' || $pluginId == 2286 /*wifip*/) {
						continue;
					}

					if ($jsonrpc->sendRequest('market::byId', ['id' => $pluginId])) {
						$result = $jsonrpc->getResult();
						$plugins[$i]['id'] = $pluginId;
						$plugins[$i]['name'] = $result['name'];
						$plugins[$i]['icon'] = $marketURL . '/' . $result['img']['icon'];
						$plugins[$i]['installed'] = is_file(__DIR__ . '/../../../' . $result['logicalId'] . '/plugin_info/info.json');
					}
				}
			}
		}
		ajax::success(array('servicePack' => $servicePack, 'plugins' => $plugins));
	}


	if (init('action') == 'dnsInstall') {
		ajax::success(jeeasy::dns_Go());
	}

	// if (init('action') == 'installPlugin') {
	// 	if (init('branch')) {
	// 		$checkInstall = jeeasy::checkInstallPlugin(init('id'), init('branch'));
	// 	} else {
	// 		if (config::byKey('core::branch') == 'beta' || config::byKey('core::branch') == 'alpha') {
	// 			$checkInstall = jeeasy::checkInstallPlugin(init('id'), 'beta');
	// 		} else {
	// 			$checkInstall = jeeasy::checkInstallPlugin(init('id'));
	// 		}
	// 	}
	// 	if ($checkInstall == 'OK') {
	// 		ajax::success();
	// 	} else {
	// 		ajax::error($checkInstall);
	// 	}
	// }

	// if (init('action') == 'installDepPlugin') {
	// 	$checkInstall = jeeasy::checkDependancyPlugin(init('id'));
	// 	if ($checkInstall == 'OK') {
	// 		ajax::success();
	// 	} else {
	// 		ajax::error($checkInstall);
	// 	}
	// }


	// if (init('action') == 'configInternalPlugin') {
	// 	$check = jeeasy::configInternalPlugin(init('typeConfig'), init('typeBox'), init('pluginName'));
	// 	ajax::success($check);
	// }


	throw new Exception(__('Aucune méthode correspondante à', __FILE__) . ' : ' . init('action'));
} catch (Exception $e) {
	ajax::error(displayException($e), $e->getCode());
}
