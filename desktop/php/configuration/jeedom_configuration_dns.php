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
    <div class="jeeasyDisplay dns">
    <div class="col-md-12 text-center" style="margin-bottom: 15px;">
        <h2 style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 12px; text-transform: uppercase; color: #737373; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);">
            {{Accès à distance}}
        </h2>
    </div>
    <div class="nos-services text-center">
        <div id="backup" class="col-xs-18 col-sm-6 col-md-3 services">
            <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180; height: 430px;">
                <img src="plugins/jeeasy/core/img/service_cadenas.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;">
                <div class="caption">
                    <h4>{{Accès à distance simplifié}}</h4>
                    <p></p>
                    <p class="text-center">
                        <a href="https://jeedom.github.io/documentation/howto/fr_FR/mise_en_place_dns_jeedom" target="_blank" class="btn btn-default btn-xs" role="button">
                            <i class="fas fa-book"></i>
                            Documentation
                        </a>
                    </p>
                    <p></p>
                    <p>
                        {{Nous l'appelons DNS, celui-ci permet de ne pas gérer de port, certificat, adresse ip etc...
                        Tout se fait tout seul et avec une grande sécurité. Vous pouvez même personnaliser le nom de votre accès.}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <style>
        .nos-services{
            margin-top:15px;
            text-align: center;
        }
        #backup{
            margin-left:12%;
        }
    </style>
<?php

if ($configs['dns::token'] == '') {
    //        echo ' pas le droit au DNS';
    ?>
    <div class="col-xs-6">
        <div style="text-align: center; font-size: 15px; font-weight: bold; margin-left: 12px; margin-bottom: 12px; text-transform: uppercase;">
            <br />
            {{Activez-le maintenant }}
        </div>
        <div style="text-align: center;">
            <a href="https://www.jeedom.com/market/index.php?v=d&p=profils#services" style="background-color: #87cf09 !important; font-size: 1em; color: white !important; margin-left: 12px;" class="btn" id="bt_addActionOnMessage">
                <i class="fas fa-plus-circle"></i>
                {{Activer}}
            </a>
        </div>
    </div>
    <?php
}else{
    //    echo 'a le droit au DNS';
    //    print_r($configs);
    ?>

    <div class="col-xs-6">
        <div style="text-align: center; font-size: 15px; font-weight: bold; margin-left: 12px; margin-bottom: 12px; text-transform: uppercase;">
            <br />
            {{Activez-le maintenant }}
        </div>
        <div style="text-align: center;">
            <!--            <a href="#" style="background-color: #87cf09 !important; font-size: 1em; color: white !important; margin-left: 12px;" class="btn" id="bt_addActionOnMessage">-->
            <a href="#" onclick="afficher()" style="background-color: #87cf09 !important; font-size: 1em; color: white !important; margin-left: 12px;" class="btn" id="bt_addActionOnMessage">
                <i class="fas fa-plus-circle"></i>
                {{Activer}}
            </a>
        </div>
    </div>
    <!--    <div class="col-sm-6">-->
    <!--        <div style="text-align: center; font-size: 15px; font-weight: bold; margin-left: 12px; margin-bottom: 12px; text-transform: uppercase;">-->
    <!--            <br />-->
    <!--            {{Ou créer le }}-->
    <!--        </div>-->
    <!--        <form class="form-horizontal">-->
    <!--            <fieldset>-->
    <!--                <legend style="color: #87cf09;">{{Accès externe}}</legend>-->
    <!--                <div class="form-group">-->
    <!--                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label" style="text-align: left">{{Protocole}}</label>-->
    <!--                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
    <!--                        <div class="input-group">-->
    <!--                            <select class="configKey form-control" data-l1key="externalProtocol" style="width: auto;">-->
    <!--                                <option value="">{{Aucun}}</option>-->
    <!--                                <option value="http://">HTTP</option>-->
    <!--                                <option value="https://">HTTPS</option>-->
    <!--                            </select>-->
    <!--                            <span class="input-group-addon">://</span>-->
    <!--                            <input type="text" class="configKey form-control" data-l1key="externalAddr" />-->
    <!--                            <span class="input-group-addon">:</span>-->
    <!--                            <input type="number" class="configKey form-control" data-l1key="externalPort" />-->
    <!--                            <span class="input-group-addon">/</span>-->
    <!--                            <input type="text" class="configKey form-control" data-l1key="externalComplement" />-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </fieldset>-->
    <!--        </form>-->
    <!--    </div>-->
    <!--    <div class="col-lg-6 activerDns" style="margin-top: 20px; visibility: hidden">-->
    <div class="col-lg-6 activerDns" style="margin-top: 20px;">
        <form class="form-horizontal">
            <fieldset>
                <?php
                foreach ($repos as $key => $value) {
                    if (!isset($value['scope']['proxy']) || $value['scope']['proxy'] === false) {
                        continue;
                    }
                    if ($configs[$key . '::enable'] == 0) {
                        continue;
                    }
                    echo '<legend style="color: #87cf09;">{{DNS (proxy)}} ' . $value['name'] . '</legend>';
                    if ($configs['dns::token'] == '') {
                        echo '<div class="alert alert-warning">{{Attention : cette fonctionnalité n\'est pas disponible dans le service pack community (voir votre service pack sur votre page profil sur le market)}}</div>';
                        continue;
                    }
                    echo '<div class="form-group divCheckboxDns">';
                    echo '<label class="col-xs-5 control-label">{{Utiliser les DNS}} ' . config::byKey('product_name') . '</label>';
                    echo '<div class="col-xs-7">';
                    echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::allowDNS" id="dnsCheked"/>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label class="col-xs-5 control-label">{{Statut DNS}}</label>';
                    echo '<div class="col-xs-7">';
                    if ($configs['market::allowDNS'] == 1 && network::dns_run()) {
                        echo '<span class="label label-success" style="font-size : 1em; background-color: #87cf09; padding: 4px !important;">{{Démarré : }} <a href="' . network::getNetworkAccess('external') . '" target="_blank" style="color:white;text-decoration: underline;">' . network::getNetworkAccess('external') . '</a></span>';
                    } else {
                        echo '<span class="label label-warning" title="{{Normal si vous n\'avez pas coché la case : Utiliser les DNS}} ' . config::byKey('product_name') . '">{{Arrêté}}</span>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label class="col-xs-5 control-label">{{Gestion}}</label>';
                    echo '<div class="col-xs-7">';
                    echo '<a style=" background-color: #87cf09; background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-success" id="bt_restartDns"><i class=\'fas fa-play\'></i> {{(Re)démarrer}}</a> ';
                    echo '<a class="btn btn-danger" id="bt_haltDns"><i class=\'fas fa-stop\'></i> {{Arrêter}}</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </fieldset>
        </form>
    </div>
    </div>


    <?php
}
//print_r($configs);

include_file('desktop', 'jeedom.configuration.wizard', 'modal', 'jeeasy');
