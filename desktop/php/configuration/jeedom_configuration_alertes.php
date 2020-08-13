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

<div class="jeeasyDisplay alerts">
    <center><i class="fas fa-bell" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);">{{Nous allons voir ici comment votre}} <?php echo config::byKey('product_name'); ?>
        {{peut vous contacter}}
    </div>
    <p style="text-align: center; margin-bottom: 20px; font-size: 15px;">{{Si ces seuils sont atteints vous recevrez des alertes}}</p>
    <form style="padding-left: 22em;" class="form-horizontal">
        <fieldset>
            <legend style="color: #87cf09;" >{{Alertes}}</legend>
            <div class="form-group">
                <label class="col-xs-3 control-label help" data-help="{{ Réglage d'activation d'alertes en cas de message sur la box }}<?php echo config::byKey('product_name'); ?> {{. (Notification...) }}">{{Action sur message}}</label>
                <div class="col-xs-4">
                    <a style="background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-success" id="bt_addActionOnMessage"><i class="fas fa-plus-circle"></i> {{Ajouter}}</a>
                </div>
            </div>
            <div id="div_actionOnMessage"></div>
            <hr/>
            <?php
            $help = array(
                "Permet de savoir quelle commande doit être exécutée pour vous avertir d'une action qui n'a pas eu le temps d'être exécutée",
                "Permet de savoir quelle commande doit être exécutée pour avertir d'un module qui n'a plus de piles",
                "Permet de savoir quelle commande doit être exécutée pour les modules en Danger"
            );
            $i=0;
            foreach ($JEEDOM_INTERNAL_CONFIG['alerts'] as $level => $value) {
                if (!in_array($level, array('timeout', 'batterydanger', 'danger'))) {
                    continue;
                }
                echo '<div class="form-group">';
                echo '<label class="col-xs-3 control-label help" data-help="{{'.$help[$i].'}}">{{Commande sur}} ' . $value['name'] . '</label>';
                echo '<div class="col-xs-4">';
                echo '<div class="input-group">';
                echo '<input type="text"  class="configKey form-control" data-l1key="alert::' . $level . 'Cmd" />';
                echo '<span class="input-group-btn">';
                echo '<a class="btn btn-default cursor bt_selectAlertCmd" title="{{Rechercher une commande}}" data-type="' . $level . '"><i class="fas fa-list-alt"></i></a>';
                echo '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            ?>
        </fieldset>
    </form>
</div>
