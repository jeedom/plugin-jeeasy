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



	if (init('action') == 'choiceLanguageJeeasy') {
		ajax::success(jeeasy::changeLanguage(init('choice')));
	}

	if (init('action') == 'dnsInstall') {
		ajax::success(jeeasy::dns_Go());
	}





	if (init('action') == 'changeBoxName') {
		if (init('choice') != '') {
			$sanitizeString = htmlspecialchars(init('choice'), ENT_NOQUOTES, 'UTF-8');
			config::save('name', $sanitizeString);
		}
		ajax::success();
	}


	if (init('action') == 'installPlugin') {
		if (init('branch')) {
			$checkInstall = jeeasy::checkInstallPlugin(init('id'), init('branch'));
		} else {
			if(config::byKey('core::branch') == 'beta' || config::byKey('core::branch') == 'alpha'){
  				$checkInstall = jeeasy::checkInstallPlugin(init('id'), 'beta');
			}else{
  				$checkInstall = jeeasy::checkInstallPlugin(init('id'));
			}
		}
		if ($checkInstall == 'OK') {
			ajax::success();
		} else {
			ajax::error($checkInstall);
		}
	}

	if (init('action') == 'installDepPlugin') {
		$checkInstall = jeeasy::checkDependancyPlugin(init('id'));
		if ($checkInstall == 'OK') {
			ajax::success();
		} else {
			ajax::error($checkInstall);
		}
	}


	if (init('action') == 'configInternalPlugin') {
		$check = jeeasy::configInternalPlugin(init('typeConfig'), init('typeBox'), init('pluginName'));
		ajax::success($check);
	}


	throw new Exception(__('Aucune méthode correspondante à', __FILE__) . ' : ' . init('action'));
	/*     * *********Catch exeption*************** */
} catch (Exception $e) {
	if (version_compare(jeedom::version(), '4.4', '>=')) {
		ajax::error(displayException($e), $e->getCode());
	} else {
		ajax::error(displayExeption($e), $e->getCode());
	}
}
