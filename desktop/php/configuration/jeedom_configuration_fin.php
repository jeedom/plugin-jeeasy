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

<div class="jeeasyDisplay end">
    <center><i class="fas fa-check" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);" class="alert">
        {{Bravo !!! Vous avez fini de configurer votre}} <?php echo config::byKey('product_name'); ?>
    </div>
    <div style="color: #87cf09; text-align: center; font-size: 15px;">
        {{Cliquez sur }}
        <i style="color: #5a5a5a; " class="fas fa-check-circle"></i>
        {{ pour valider votre configuration}}
    </div>
</div>
