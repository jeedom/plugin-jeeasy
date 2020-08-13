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

<div class="jeeasyDisplay eqLogic">
    <center><i class="icon divers-svg" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);" class="alert">{{Nous allons ici configurer le seuil batterie de votre}} <?php echo config::byKey('product_name'); ?></div>
    <form style="padding-left: 15em;" class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 col-md-offset-3 control-label help" data-help="Sera utile pour les alertes ">{{Seuil des piles}}</label>
            </div>
            <div class="form-group" style="margin-left: 20%">
                <label class="col-lg-1 col-md-1 col-sm-1 col-xs-1 eqLogicAttr label label-danger" style="font-size : 1.4em">
                    {{Danger}}
                </label>
                <div class="col-xs-1" style=" width: 10%; font-weight: bold;">
                    <input class="configKey form-control" data-l1key="battery::danger" />
                </div>
            </div>
            <div class="form-group" style="margin-left: 20.6%;  font-weight: bold">
                <label class="col-xs-1 label label-warning" style="font-size : 1.4em; padding: 10px 6px !important; width: 25.8%;">
                    {{Warning}}
                </label>
                <div class="col-xs-1" style="margin-left: 0.7%; width: 10%;">
                    <input class="configKey form-control" data-l1key="battery::warning" />
                </div>
            </div>
        </fieldset>
    </form>
</div>
