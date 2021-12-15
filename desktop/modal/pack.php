<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}



if( file_exists( config::byKey('path_wizard') ) )
  $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard' ) ), true );
else
  $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.json'), true );

$custom = null;



$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');



if ($jsonrpc->sendRequest('servicepack::info')) {
    $result = $jsonrpc->getResult();
    $servicePack = $result['licenceName'];
    $nbService = $result['licenceNumber'];
    $pluginsPack = $result['licencePlugins'];
    $mainPlugins = $result['mainPlugins'];
    $arrPlugins = array();

    if(is_array($mainPlugins) && !empty($mainPlugins) && $servicePack != 'Community'){
        foreach($mainPlugins as $plugin){
                $arrPlugin = array( 'id' => array(), 'name' => array(), 'logicalId' => array(), 'img' => array());
                $arrId = array();
                $arrId['id'] = $plugin;
			    if ( $jsonrpc->sendRequest('market::byId', $arrId)) {
                      $resultMain = $jsonrpc->getResult();
                      $logicalPlugin = $resultMain['logicalId'];
                      $namePlugin = $resultMain['name'];
                      $imgPlugin = $resultMain['img'];
                      array_push($arrPlugin['id'], $plugin);
                      array_push($arrPlugin['name'], $namePlugin);
                      array_push($arrPlugin['logicalId'], $logicalPlugin);
                      array_push($arrPlugin['img'], $imgPlugin['icon']);
                  }
          array_push($arrPlugins, $arrPlugin);
        }
    }

    if($pluginsPack != 'official'){
          if(is_array($pluginsPack) && !empty($pluginsPack) && $servicePack != 'Community'){
                foreach($pluginsPack as $plugin){
                        $arrPlugin = array( 'id' => array(), 'name' => array(), 'logicalId' => array(), 'img' => array());
                        $arrId = array();
                        $arrId['id'] = $plugin;
												if(is_int($arrId['id'])){
													if ( $jsonrpc->sendRequest('market::byId', $arrId)) {
																$resultMain = $jsonrpc->getResult();
																$logicalPlugin = $resultMain['logicalId'];
																$namePlugin = $resultMain['name'];
																$imgPlugin = $resultMain['img'];
																array_push($arrPlugin['id'], $plugin);
																array_push($arrPlugin['name'], $namePlugin);
																array_push($arrPlugin['logicalId'], $logicalPlugin);
																array_push($arrPlugin['img'], $imgPlugin['icon']);
														}
										    array_push($arrPlugins, $arrPlugin);
												}

                }
            }
   }

}
 if($servicePack != 'Community'){
?>
	<script>

		$('#bt_next').hide();
		$('#bt_prev').hide();
		$('.textAtlas').text('{{Choix des plugins à installer : }}');
	    $('#btn-choicePlugin').on('click', function () {
				console.log('clickk');
				$('#tabPlugins').hide();
				var i = 0;
				var pluginsCheck = [];
				$('input:checked[id=checkPluginToInstall]').each(function(){
							i++;
							var idplugin= $(this).attr("name");
							pluginsCheck.push(idplugin);
				 });
				 if(i != 0){
					$('.textAtlas').text('{{Installation des plugins en cours : }}');
					progress(20);
	 				installPluginCheck(pluginsCheck);
	 			}	else{
	 				$('.textAtlas').text('{{Vous n avez selectionne aucun plugin à installer, cliquez sur suivant : }}');
					$('#btn-choicePlugin').hide();
	 				$('#bt_next').show();
	 			}

        });




function installPluginCheck(pluginsCheck){
  for (const pluginId of pluginsCheck) {
          $.ajax({
			type: "POST",
			url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
			data: {
			    action: "installPlugin",
			    id: pluginId

			},
			dataType: 'json',
			error: function(request, status, error) {
					handleAjaxError(request, status, error);
			},
			success: function(data) {
				testDep(pluginId);
				progress(50);
			}
    	   });

  }


}


      function testDep(idPlugin){
        $.ajax({
          type: "POST",
          url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
          data: {
              action: "installDepPlugin",
              id: idPlugin
          },
          dataType: 'json',
          error: function(request, status, error) {
              handleAjaxError(request, status, error);
          },
          success: function(data) {
            progress(100);
            $('#servicePackh3').text('{{ Vos plugins sont prêts }}');
						$('#btn-choicePlugin').hide();
          }
          });
       }


      function progress(ProgressPourcent){
        if(ProgressPourcent == -1){
            $('#div_progressbar').removeClass('progress-bar-success progress-bar-info progress-bar-warning');
            $('#div_progressbar').addClass('active progress-bar-danger');
            $('#div_progressbar').width('100%');
            $('#div_progressbar').attr('aria-valuenow',100);
            $('#div_progressbar').html('N/A');
            return;
        }
        if(ProgressPourcent == 100){
            $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
            $('#div_progressbar').addClass('progress-bar-success');
            $('#div_progressbar').width(ProgressPourcent+'%');
            $('#div_progressbar').attr('aria-valuenow',ProgressPourcent);
            $('#div_progressbar').html('FIN');
						$('.textAtlas').hide();
            Good();
            return;
        }
        $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
        $('#div_progressbar').addClass('progress-bar-success');
        $('#div_progressbar').width(ProgressPourcent+'%');
        $('#div_progressbar').attr('aria-valuenow',ProgressPourcent);
        $('#div_progressbar').html(ProgressPourcent+'%');
      }
      function Good(){
        $('#bt_next').show();
        $('#bt_prev').show();
        $('.img-atlas').attr('src', '<?php echo config::byKey('product_connection_image'); ?>');
      }
      </script>

      <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
      <div class="col-md-12 text-center">
      <p class="text-center"><h3 class="servicePack" id="servicePackh3">Vous êtes en <?= $servicePack ?></h3></p>
      <p class="text-center"><h4 class="textAtlas"></h4></p>

      <table class="table table-hover" id="tabPlugins"  style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <thead>
            </thead>
              <tbody>
                   <?php
                            foreach($arrPlugins as $plugin){
                                 echo '<tr>';
                                 echo '<td style="display:flex;justify-content:space-between;align-items:center;" ><img class="test" src="'.$marketURL.'/'.$plugin["img"][0].'" style="height:40px; width:40px; margin-right:20px">';
                                 echo $plugin['name'][0];
                                 echo '<input type="checkbox" class="checkPluginToInstall" id="checkPluginToInstall" name="'.$plugin['logicalId'][0].'" style="margin-left:20px;">';
                                 echo '</td>';
                                 echo '<tr>';
                              }
                    ?>
             </tbody>


      </table>
       <div class="testbtn">
           <a class='btn btn-success btn-md pull-right' id="btn-choicePlugin" style="margin-right:50px" >Valider</a>
       </div>

      <div id="contenuTextSpan" class="progress">
      	<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
      	</div>
      </div>
      </div>
      </div>

<?php
}elseif($servicePack == 'Community'){

?>

<h2 class="center">{{Découvrez nos Services Packs}}</h2>
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Community</th>
              <th>Power</th>
              <th>Ultimate</th>
              <th>Pro</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{Inclus avec}}</td>
              <td>{{Tous}}</td>
              <td>{{Box Smart}}</td>
              <td>{{En option (45€)}}</td>
              <td>{{Box Pro}}</td>
            </tr>
            <tr>
              <td>{{Plugins offerts}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td>{{Alarme et RFXcom}}</td>
              <td>{{Tous les Officiels}}</td>
              <td>{{Tous les Officiels}}</td>
            </tr>
            <tr>
              <td>{{Passerelle SMS crédit (web)}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{60 SMS offerts}}</td>
              <td>{{60 SMS offerts}}</td>
              <td>{{100 SMS offerts}}</td>
            </tr>
            <tr>
              <td>{{Passerelle VOIP (web)}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
            </tr>
            <tr>
              <td>{{Périphériques supportés}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
            </tr>
            <tr>
              <td>{{Multi Antennes déportées}}</td>
              <td>1</td>
              <td>4</td>
              <td>4</td>
              <td>9</td>
            </tr>
            <tr>
              <td>{{Application native IOS/Android}}</td>
              <td>4€</td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{DNS dynamique et HTTPS}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Backup cloud}}</td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
            </tr>
	    <tr>
              <td>{{Monitoring}}</td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
	    </tr>
            <tr>
              <td>{{Accès à la gestion de Parc}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Marque blanche}} <sup>(1)</sup></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Support forum}}</td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Assistance Jeedom}} <sup>(2)</sup></td>
              <td>{{2 / mois}}<sup>(3)</sup></td>
              <td>{{10 / mois}}</td>
              <td>{{10 / mois}}</td>
              <td>{{Illimité}}</td>
            </tr>
            <tr>
              <td>{{Délai de réponse}} </td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td>{{Rapide}}</td>
              <td>{{Rapide}}</td>
              <td>{{48 h ouvrées}}</td>
            </tr>
            <tr>
              <td></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://jeedom.github.io/documentation/installation/fr_FR/index">{{Gratuit}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{Acheter}} (50€)</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{Acheter}} (85€)</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" href="https://www.jeedom.com/site/fr/pro.html">{{En savoir plus}}</a></td>
            </tr>

          </tbody>
        </table>
        <p style="font-size:10px; line-height:14px;">
        <sup>(1)</sup> : {{Selon conditions contractuelles}}<br/>
	<sup>(2)</sup> : {{Tickets sur plugin officiel}}<br/>
	<sup>(3)</sup> : {{Uniquement sur les plugins payants}}<br/>
        </p>


<?php } ?>
