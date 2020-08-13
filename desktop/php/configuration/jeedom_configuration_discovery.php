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
<div class="jeeasyDisplay discovery">
    <center><i class="fas fa-th" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);" >
        {{Nous allons choisir d'activer les propositions de plugins}}
    </div>
    <div style="text-align: center; font-size: 15px;">
        {{Nous pouvons vous proposer des plugins complémentaires à votre matériel et aux plugins déjà actifs.}}
    </div>
    <div class="form-group" style="margin-top: 1%;">
        <label class=" control-label" style="margin-left: 37%;">{{Activer les propositions de plugins}}</label>
        <a  style="background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-default testRepoConnection" data-repo="' . $key . '">
            <i class="fas fa-check"></i>
            {{  Activer}}
        </a>
    </div>
</div>
