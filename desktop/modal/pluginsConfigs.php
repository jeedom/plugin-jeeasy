<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

if (file_exists(config::byKey('path_pluginConfig'))) {
    $path_pluginsConf = json_decode(file_get_contents(config::byKey('path_pluginConfig')), true);
} else {
    $path_pluginsConf = json_decode(file_get_contents('plugins/jeeasy/core/data/pluginConfig.json'), true);
}

$productName = jeedom::getHardwareName();
$listPlugins = plugin::listPlugin();

$jsonData = file_get_contents('plugins/jeeasy/core/data/pluginConfig.json');
$jsonData = json_decode($jsonData, true);
$arrayProtocols = array_keys($jsonData['pluginsInfos']);

$arrayConfigChoice = [];


$i = 0;
$countProtocols = 0;   

?>
<script>

var btNext = document.getElementById('bt_next');
var choiceModeElement = document.getElementById('choiceMode');
var textConfigAutoPlugElement = document.querySelector('.textConfigAutoPlug');
var testbtnb = document.querySelector('.testbtnb');


btNext.style.display = 'none';

function callAjax(choiceConfig, typeBox, pluginName){
                    $.ajax({
                      type: "POST",
                      url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
                      data: {
                          action: "configInternalPlugin",
                          typeConfig: choiceConfig,
                          typeBox: typeBox,
                          pluginName: pluginName
                      },
                      dataType: 'json',
                      error: function(request, status, error) {
                          console.log(status);
                          handleAjaxError(request, status, error);
                      },
                      success: function(data) {
                          if (data.result == 'usb') {
                            textConfigAutoPlugElement.innerHTML = '{{Vous avez choisi un contrôleur USB, veuillez le configurer dans la gestion de votre plugin}}';
                            choiceModeElement.style.display = 'none';
                          } else if (data.result == 'gpio') {
                            choiceModeElement.style.display = 'none';
                            textConfigAutoPlugElement.innerHTML = '{{Votre plugin à été configuré automatiquement}}';
                            btNext.style.display = 'block';

                          }
                      }
                  });    
      }
</script>
  
<?php

if ($listPlugins) {
    if($productName == 'Luna') {
        foreach ($listPlugins as $plugin) {
            $nameplug = $plugin->getId();
            if (in_array($nameplug, $arrayProtocols) == true) {
                $nameplug = $plugin->getId();
                jeeasy::configInternalPlugin('gpio', $productName, $nameplug);
                log::add('jeeasy', 'info', 'Configuration automatique du plugin ' . $nameplug . ' pour le produit Luna');
            }
        } 
        ?> 
            <script>
                choiceModeElement.style.display = 'none';
                testbtnb.style.display = 'none';
                textConfigAutoPlugElement.innerHTML = '{{La configuration automatique des plugins pour la Luna a été effectuée, vous pouvez cliquer sur la flèche pour continuer}}';
                if(document.getElementById('btn-choiceConfig')){
                        document.getElementById('btn-choiceConfig').style.display = 'none';
                        document.getElementById('contenuTextSpan').style.display = 'none';
                        //div_progressbar
                }
                if(document.getElementById('pluginsConfigSelect')){
                        document.getElementById('pluginsConfigSelect').style.display = 'none';
                        document.getElementById('contenuTextSpan').style.display = 'none';
                }
                btNext.style.display = 'block';
            </script>
        <?php
    } else {
        foreach ($listPlugins as $plugin) {
            $nameplug = $plugin->getId();
            if (in_array($nameplug, $arrayProtocols) == true) {
                $nameplug = $plugin->getId();
                $countProtocols++;
                $i++;
                array_push($arrayConfigChoice, $plugin);
            }
        }
      
        if($countProtocols > 1) {
          ?> <script>
                 <?php foreach($arrayConfigChoice as $plugin){ 
                    $nameplug = $plugin->getId();              
                   ?>
               
                    var pluginsConfigSelect = document.getElementById('pluginsConfigSelect');
    
                    var newOption = document.createElement('option');
    
                    newOption.setAttribute('nameplugin', '<?= $nameplug; ?>');
                    newOption.setAttribute('typebox', '<?= $productName; ?>');
                    newOption.setAttribute('config', 'gpio');
                    newOption.textContent = '<?= $nameplug; ?>';
    
                    pluginsConfigSelect.appendChild(newOption);
               <?php  } ?>
    
                        </script>
            <?php
          
          
        } elseif ($countProtocols == 1) {
          $nameplug = $arrayConfigChoice[0]->getId();
           ?>
                <script>
                    var nameplugin = '<?= $nameplug; ?>';
                    var typebox = '<?= $productName; ?>';
                    var config = 'gpio';
    
                    callAjax(config, typebox, nameplugin);
    
                    testbtnb.style.display = 'none';
    
                    var choiceModeElement = document.getElementById('choiceMode');
                    if (choiceModeElement) {
                        choiceModeElement.innerHTML = '{{Le port du plugin a été automatiquement configuré, vous pouvez cliquer sur la flèche pour continuer}}';
                    }
    
                    var pluginsConfigSelectElement = document.getElementById('pluginsConfigSelect');
                    if (pluginsConfigSelectElement) {
                        pluginsConfigSelectElement.style.display = 'none';
                    }
    
                    var yourBoxIsElement = document.getElementById('yourBoxIs');
                    if (yourBoxIsElement) {
                        yourBoxIsElement.style.display = 'none';
                    }
    
                </script>
            <?php
        }
      
    
        if ($i == 0) {
            ?> <script>
                choiceModeElement.style.display = 'none';
                testbtnb.style.display = 'none';
                textConfigAutoPlugElement.innerHTML = '{{Aucun Plugin installé à paramétrer}}';
                if(document.getElementById('btn-choiceConfig')){
                    document.getElementById('btn-choiceConfig').style.display = 'none';
                    document.getElementById('contenuTextSpan').style.display = 'none';
                }
                if(document.getElementById('pluginsConfigSelect')){
                    document.getElementById('pluginsConfigSelect').style.display = 'none';
                    document.getElementById('contenuTextSpan').style.display = 'none';
                }
                btNext.style.display = 'block';
            </script>
        <?php
    
        }        
    }

} else {
    ?> <script>
        choiceModeElement.style.display = 'none';
        testbtnb.style.display = 'none';
        textConfigAutoPlugElement.innerHTML = '{{Aucun Plugin installé à paramétrer}}';
        if(document.getElementById('btn-choiceConfig')){
                document.getElementById('btn-choiceConfig').style.display = 'none';
                document.getElementById('contenuTextSpan').style.display = 'none';
                //div_progressbar
        }
        if(document.getElementById('pluginsConfigSelect')){
                document.getElementById('pluginsConfigSelect').style.display = 'none';
                document.getElementById('contenuTextSpan').style.display = 'none';
        }
        btNext.style.display = 'block';
    </script>
<?php
}

?>
<script>
  
  document.getElementById('btn-pluginConfigIgnore').addEventListener('click', function() {
      btNext.click();
      btNext.style.display = 'block';
  });



  
  document.getElementById('btn-validateConfig').addEventListener('click', function() {
        var countProtocols = '<?= $countProtocols; ?>';
        if(countProtocols > 1){
            var selectedOption = document.getElementById('pluginsConfigSelect').options[pluginsConfigSelect.selectedIndex];
            var choiceConfig = selectedOption.getAttribute('config');
            var typeBox = selectedOption.getAttribute('typebox');
            var pluginName = selectedOption.getAttribute('nameplugin');          
            if(choiceConfig == ''){           
                choiceModeElement.style.display = 'none';
                textConfigAutoPlugElement.innerHTML = '{{Aucun Plugin installé à paramétrer, cliquez sur Suivant}}';
                btNext.style.display = 'none';
                
            }else{
            callAjax(choiceConfig, typeBox, pluginName);
            }                  
        }else{
            choiceModeElement.style.display = 'none';
            textConfigAutoPlugElement.innerHTML = '{{Aucun Plugin installé à paramétrer, cliquez sur Suivant}}';
            btNext.style.display = 'block';

        
        }
    });


    document.getElementById('pluginsConfigSelect').addEventListener('change', function() {
        choiceModeElement.style.display = 'block';
        textConfigAutoPlugElement.innerHTML = '';
    });

</script>


<div class="mainContainer" style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
    <div >
        <img class="img-responsive center-block img-atlas" style="width:60%;height:60%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
        <div class="col-md-12 text-center">
            <p class="text-center">
                <h3 class="configplugins">{{Configuration Auto des Plugins}} :</h3>
            </p>
            <p class="text-center">
                <h4 class="configplugins" id="choiceMode">{{Quel plugin souhaitez vous que Jeedom configure automatiquement le port ?}} :</h4>
            </p>
        
            <p class="text-center">
                <h4 class="textConfigAutoPlug" style="color:#93ca02;"></h4>
            </p>
            <table class="table table-hover" id="pluginsConfigTab" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
                <thead>
                </thead>
                <tbody>
                    <select id="pluginsConfigSelect" style="width:250px">
                    </select>
                </tbody>
            </table>
        
            <div class="testbtnb" style="display:flex; flex-direction:row;justify-content:center; align-items:center;">
                <button type="button" class="btn btn-primary btn-success btn-lg" id="btn-validateConfig" style="margin-bottom:10px;">{{Valider la configuration}}</button>
                <button type="button" class="btn btn-primary btn-primary btn-lg" id="btn-pluginConfigIgnore" style="margin-left:35px;margin-bottom:10px;">{{Ignorer}}
            </div>


            <div id="contenuTextSpan" class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
        </div>
    </div>
</div>