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

<div class="jeeasyDisplay network">
    <center><i class="fas fa-wifi" style="font-size: 10em; padding-top: 20px;"></i></center>
    <br/>
    <div  style="text-align: center; margin-bottom: 20px;" class="alert">
        <p style="text-align: center; font-weight: bold; text-transform: uppercase; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);">
        {{Nous allons ici configurer le réseau de votre}} <?php echo config::byKey('product_name'); ?>.</p>
        <p>
            {{ La plupart du temps la configuration par défaut est correcte et vous n'avez pas à la modifier}}
        </p>
    </div>
    <form class="form-horizontal">
        <fieldset>
            <legend class="help" style="color: #87cf09;" data-help="{{Attention : cette configuration n'est là que pour informer Jeedom de sa configuration réseau et n'a aucun impact sur les ports ou l'IP réellement utilisés pour joindre Jeedom}}" >{{Accès local}}</legend>
            <div class="form-group">
                <label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 control-label help" data-help="{{Sélectionner http ou https}}">{{Protocole}}</label>
                <div class="col-lg-8 col-md-9 col-sm-8 col-xs-6">
                    <div class="input-group">
                        <select class="configKey form-control" data-l1key="internalProtocol">
                            <option value="">{{Aucun}}</option>
                            <option value="http://">HTTP</option>
                            <option value="https://">HTTPS</option>
                        </select>
                        <span class="input-group-addon">://</span>
                        <input type="text" class="configKey form-control" data-l1key="internalAddr" />
                        <span class="input-group-addon">:</span>
                        <input type="number" class="configKey form-control" data-l1key="internalPort" />
                        <span class="input-group-addon">/</span>
                        <input type="text" class="configKey form-control" data-l1key="internalComplement" />
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <!--********************************************* a enlever **********************************************************-->
<!--    <form class="form-horizontal">-->
<!--        <fieldset>-->
<!--            <legend style="color: #87cf09;">{{Accès externe}}</legend>-->
<!--            <div class="form-group">-->
<!--                <label class="col-lg-2 col-md-3 col-sm-4 col-xs-6 control-label">{{Protocole}}</label>-->
<!--                <div class="col-lg-8 col-md-9 col-sm-8 col-xs-6">-->
<!--                    <div class="input-group">-->
<!--                        <select class="configKey form-control" data-l1key="externalProtocol">-->
<!--                            <option value="">{{Aucun}}</option>-->
<!--                            <option value="http://">HTTP</option>-->
<!--                            <option value="https://">HTTPS</option>-->
<!--                        </select>-->
<!--                        <span class="input-group-addon">://</span>-->
<!--                        <input type="text" class="configKey form-control" data-l1key="externalAddr" />-->
<!--                        <span class="input-group-addon">:</span>-->
<!--                        <input type="number" class="configKey form-control" data-l1key="externalPort" />-->
<!--                        <span class="input-group-addon">/</span>-->
<!--                        <input type="text" class="configKey form-control" data-l1key="externalComplement" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </fieldset>-->
<!--    </form>-->
<!--    <form class="form-horizontal">-->
<!--        <fieldset>-->
<!--            --><?php
//            foreach ($repos as $key => $value) {
//                if (!isset($value['scope']['proxy']) || $value['scope']['proxy'] === false) {
//                    continue;
//                }
//                if ($configs[$key . '::enable'] == 0) {
//                    continue;
//                }
//                echo '<legend style="color: #87cf09;">{{DNS (proxy)}} ' . $value['name'] . '</legend>';
//                if ($configs['dns::token'] == '') {
//                    echo '<div class="alert alert-warning">{{Attention : cette fonctionnalité n\'est pas disponible dans le service pack community (voir votre service pack sur votre page profil sur le market)}}</div>';
//                    continue;
//                }
//                echo '<div class="form-group">';
//                echo '<label class="col-xs-4 control-label">{{Utiliser les DNS}} ' . config::byKey('product_name') . '</label>';
//                echo '<div class="col-xs-8">';
//                echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::allowDNS" />';
//                echo '</div>';
//                echo '</div>';
//                echo '<div class="form-group">';
//                echo '<label class="col-xs-4 control-label">{{Statut DNS}}</label>';
//                echo '<div class="col-xs-8">';
//                if ($configs['market::allowDNS'] == 1 && network::dns_run()) {
//                    echo '<span class="label label-success" style="font-size : 1em; background-color: #87cf09; padding: 4px !important;">{{Démarré : }} <a href="' . network::getNetworkAccess('external') . '" target="_blank" style="color:white;text-decoration: underline;">' . network::getNetworkAccess('external') . '</a></span>';
//                } else {
//                    echo '<span class="label label-warning" title="{{Normal si vous n\'avez pas coché la case : Utiliser les DNS}} ' . config::byKey('product_name') . '">{{Arrêté}}</span>';
//                }
//                echo '</div>';
//                echo '</div>';
//                echo '<div class="form-group">';
//                echo '<label class="col-xs-4 control-label">{{Gestion}}</label>';
//                echo '<div class="col-xs-8">';
//                echo '<a style=" background-color: #87cf09; background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-success" id="bt_restartDns"><i class=\'fas fa-play\'></i> {{(Re)démarrer}}</a> ';
//                echo '<a class="btn btn-danger" id="bt_haltDns"><i class=\'fas fa-stop\'></i> {{Arrêter}}</a>';
//                echo '</div>';
//                echo '</div>';
//            }
//            ?>
<!--        </fieldset>-->
<!--    </form>-->
    <!--***************************************************** fin *******************************************************************-->
</div>
