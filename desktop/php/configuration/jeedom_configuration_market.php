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

<!-- ********************************************code modifié ***************************************** -->
<div class="jeeasyDisplay market">
    <center><i class="far fa-credit-card" style="font-size: 10em;; padding-top: 20px;"></i></center>
    <br/>
    <center>
        <div style="text-align: center; font-weight: bold; text-transform: uppercase; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);">
            {{Nous allons ici configurer la connexion de votre }} <?php echo config::byKey('product_name'); ?> {{au market}}
        </div>
        <div style="text-align: center; margin-bottom: 20px; font-size: 14px;" class="alert">
            {{Vous pourrez ainsi télécharger les plugins pour utiliser votre matériel,
            obtenir les mises à jours,
            faire le lien avec l'application mobile...}}
        </div>
    </center>
    <form class="form-horizontal">
        <fieldset>
            <?php
            foreach ($repos as $key => $value) {
                if ($key != 'market') {
                    continue;
                }

//                echo "<pre>";
//                print_r($value);
//                echo "</pre>";

                $active = ($key == 'market') ? 'active' : '';
                echo '<div role="tabpanel" class="tab-pane ' . $active . '" id="tab' . $key . '">';
                echo '<br/>';
                echo '<div class="form-group " hidden="hidden">';
                echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Activer}} ' . $value['name'] . '</label>';
                echo '<div class="col-sm-1">';
                echo '<input type="checkbox" class="configKey enableRepository" data-repo="' . $key . '" data-l1key="' . $key . '::enable"/>';
                echo '</div>';
                echo '</div>';
                if ($value['scope']['hasConfiguration'] === false) {
                    echo '</div>';
                    continue;
                }
                echo '<div class="repositoryConfiguration' . $key . '">';
                foreach ($value['configuration']['configuration'] as $pKey => $parameter) {
                    if ($pKey == "username" || $pKey == "password"){
                        echo '<div class="form-group">';
                        if ($pKey == "username"){
                            echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label help" data-help="{{Nom d\'utilisateur utilisé pour votre compte market}}">';
                        }elseif ($pKey == "password"){
                            echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label help" data-help="{{Mot de passe utilisé pour votre compte market}}">';
                        }
                        echo $parameter['name'];
                        echo '</label>';
                        echo '<div class="col-sm-6">';
                        $default = (isset($parameter['default'])) ? $parameter['default'] : '';
                        switch ($parameter['type']) {
                            case 'checkbox':
                                echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
                                break;
                            case 'input':
                                echo '<input class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
                                break;
                            case 'number':
                                echo '<input type="number" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
                                break;
                            case 'password':
                                echo '<input type="password" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
                                break;
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                if (isset($value['scope']['test']) && $value['scope']['test']) {
                    echo '<div class="form-group">';
                    echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Vérifier le  compte}}</label>';
                    echo '<div class="col-sm-4">';
                    echo '<a  style="background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-default testRepoConnection" data-repo="' . $key . '"><i class="fas fa-check"></i> {{  Vérifier}}</a>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
        </fieldset>
    </form>
</div>
<!-- ******************************************** fin code modifié ***************************************** -->


<!--*************************************  code présent ******************************************** -->
<!--<div class="jeeasyDisplay market">-->
<!--    <center><i class="far fa-credit-card" style="font-size: 10em;; padding-top: 20px;"></i></center>-->
<!--    <br/>-->
<!--    <center><div style="text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; font-size: 20px; text-shadow: 1px 1px 1px rgba(0,0,0,0.5);" class="alert">{{Nous allons ici configurer la connexion de votre }} --><?php //echo config::byKey('product_name'); ?><!-- {{au market}}</div></center>-->
<!--    <form class="form-horizontal">-->
<!--        <fieldset>-->
<!--            --><?php
//            foreach ($repos as $key => $value) {
//                if ($key != 'market') {
//                    continue;
//                }
//
////                echo "<pre>";
////                print_r($value);
////                echo "</pre>";
//
//                $active = ($key == 'market') ? 'active' : '';
//                echo '<div role="tabpanel" class="tab-pane ' . $active . '" id="tab' . $key . '">';
//                echo '<br/>';
//                echo '<div class="form-group">';
//                echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Activer}} ' . $value['name'] . '</label>';
//                echo '<div class="col-sm-1">';
//                echo '<input type="checkbox" class="configKey enableRepository" data-repo="' . $key . '" data-l1key="' . $key . '::enable"/>';
//                echo '</div>';
//                echo '</div>';
//                if ($value['scope']['hasConfiguration'] === false) {
//                    echo '</div>';
//                    continue;
//                }
//                echo '<div class="repositoryConfiguration' . $key . '">';
//                foreach ($value['configuration']['configuration'] as $pKey => $parameter) {
//
//                    echo "<pre>";
//                print_r($pKey);
//                echo "</pre>";
//
//                    echo '<div class="form-group">';
//                    echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">';
//                    echo $parameter['name'];
//                    echo '</label>';
//                    echo '<div class="col-sm-6">';
//                    $default = (isset($parameter['default'])) ? $parameter['default'] : '';
//                    switch ($parameter['type']) {
//                        case 'checkbox':
//                            echo '<input type="checkbox" class="configKey" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//                            break;
//                        case 'input':
//                            echo '<input class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//                            break;
//                        case 'number':
//                            echo '<input type="number" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//                            break;
//                        case 'password':
//                            echo '<input type="password" class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '" value="' . $default . '" />';
//                            break;
//                        case 'select':
//                            echo '<select class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '">';
//                            foreach ($parameter['values'] as $optkey => $optval) {
//                                echo '<option value="' . $optkey . '">' . $optval . '</option>';
//                            }
//                            echo '</select>';
//                            break;
//                    }
//                    echo '</div>';
//                    echo '</div>';
//                }
//                if (isset($value['scope']['test']) && $value['scope']['test']) {
//                    echo '<div class="form-group">';
//                    echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Tester}}</label>';
//                    echo '<div class="col-sm-4">';
//                    echo '<a  style="background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-default testRepoConnection" data-repo="' . $key . '"><i class="fas fa-check"></i> {{  Tester}}</a>';
//                    echo '</div>';
//                    echo '</div>';
//                }
//                echo '</div>';
//                echo '</div>';
//            }
//            ?>
<!--        </fieldset>-->
<!--    </form>-->
<!--</div>-->
<!--  **************************  fin du code présent *************************************************  -->
