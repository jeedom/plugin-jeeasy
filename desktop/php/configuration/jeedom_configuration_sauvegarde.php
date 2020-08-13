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
    <div class="nos-services text-center">
        <div id="backup" class="col-xs-18 col-sm-6 col-md-3 services">
            <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180; height: 430px;">
                <img src="plugins/jeeasy/core/img/service_backup.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;">
                <div class="caption">
                    <h4>{{Les Sauvegardes Cloud}}</h4>
                    <p></p>
                    <p class="text-center">
                        <a href="https://jeedom.github.io/core/fr_FR/backup" target="_blank" class="btn btn-default btn-xs" role="button">
                            <i class="fas fa-book"></i>
                            {{Documentation}}
                        </a>
                    </p>
                    <p></p>
                    <p>
                        {{Nous vous proposons de sauvegarder votre Jeedom chaque nuit de façon sécurisée avec vos propres mots de passe.
                        Soyez rassurés du moindre souci sur votre Jeedom.
                        De plus nous économisons votre bande passante en sauvegardant uniquement les changements.}}
                    </p>
                </div>
            </div>
        </div>
        <!-- ************************** ajout *************************** -->
<!--        <div class="col-xs-18 col-sm-6 col-md-3">-->
            <div class="jeeasyDisplay market">
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
                            if ($value['scope']['hasConfiguration'] === false) {
                                echo '</div>';
                                continue;
                            }
                            echo '<div class="repositoryConfiguration' . $key . '">';
                            foreach ($value['configuration']['configuration'] as $pKey => $parameter) {
//                                echo $pKey;
                                if ($pKey == "cloud::backup::name" || $pKey == "cloud::backup::password" || $pKey == "cloud::backup::fullfrequency"){
                                    if ($pKey == "cloud::backup::name"){
                                        $parameter["name"]="{{Nom de votre Backup}}";
                                        $help = "{{A conserver précieusement c'est ici que vous le choisissez}}";
                                    }elseif ($pKey == "cloud::backup::password"){
                                        $parameter["name"]="{{Mot de Passe }}";
                                        $help = "{{A conserver précieusement c'est ici que vous le choisissez}}";
                                    }elseif ($pKey == "cloud::backup::fullfrequency"){
                                        $parameter["name"]="{{ Fréquence Backup Global}}";
                                        $help = "{{Permet de demander un backup complet a Jeedom, dans tout les cas vous aurez un backup nous prenons uniquement les fichiers changés}}";
                                    }
                                    echo '<div class="form-group">';
                                    echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label help" data-help="'.$help.'">';
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
                                        case 'select':
                                            echo '<select class="configKey form-control" data-l1key="' . $key . '::' . $pKey . '">';
                                            foreach ($parameter['values'] as $optkey => $optval) {
                                                echo '<option value="' . $optkey . '">' . $optval . '</option>';
                                            }
                                            echo '</select>';
                                            break;
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
//                            if (isset($value['scope']['test']) && $value['scope']['test']) {
//                                echo '<div class="form-group">';
//                                echo '<label class="col-lg-4 col-md-6 col-sm-6 col-xs-6 control-label">{{Vérifier le  compte}}</label>';
//                                echo '<div class="col-sm-4">';
//                                echo '<a  style="background-color: #87cf09 !important; font-size: 1em; color: white !important;" class="btn btn-default testRepoConnection" data-repo="' . $key . '"><i class="fas fa-check"></i> {{  Vérifier}}</a>';
//                                echo '</div>';
//                                echo '</div>';
//                            }
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </fieldset>
                </form>
        </div>

        <!-- ************************** fin ajout *************************** -->


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

echo "<pre>";
print_r($keys);
echo "</pre>";

echo "<pre>";
print_r($configs);
echo "</pre>";
