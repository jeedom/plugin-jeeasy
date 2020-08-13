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

<div class="jeeasyDisplay log">
    <center><i class="far fa-file" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);" class="alert">{{Nous allons ici configurer les logs de votre}} <?php echo config::byKey('product_name'); ?></div>
    <form class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-xs-4 control-label">{{Niveau de log par défaut}}</label>
                <div class="col-xs-4">
                    <select class="configKey form-control" data-l1key="log::level">
                        <option value="100">{{Debug}}</option>
                        <option value="200">{{Info}}</option>
                        <option value="300">{{Warning}}</option>
                        <option value="400">{{Erreur}}</option>
                    </select>
                </div>
            </div>
        </fieldset>
    </form>
</div>
