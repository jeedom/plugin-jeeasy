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

$arrayProtocols = ['eibd','zigbee','zwavejs','z2m', 'enocean'];
$arrayConfigChoice = [];


$i = 0;
$countProtocols = 0;   

?>
<script>
  $('#bt_next').hide();
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
                              $('.textConfigAutoPlug').text('{{Vous avez choisi un contrôleur USB, veuillez le configurer dans la gestion de votre plugin}}');
                              $('#choiceMode').hide();
                          } else if (data.result == 'gpio') {
                              $('#choiceMode').hide();
                              $('.textConfigAutoPlug').text('{{Votre plugin à été configuré automatiquement}}');
                              $('#bt_next').show();

                          }
                      }
                  });    
      }
</script>
  
<?php

if ($listPlugins) {
   foreach ($listPlugins as $plugin) {
       $nameplug = $plugin->getId();
        if (in_array($nameplug, $arrayProtocols) == true) {
           $nameplug = $plugin->getId();
              $countProtocols++;
              $i++;
              array_push($arrayConfigChoice, $plugin);
          
        }
   }
  
    if($countProtocols > 1){
      ?> <script>
             <?php foreach($arrayConfigChoice as $plugin){ 
                $nameplug = $plugin->getId();              
               ?>
           
                $('#pluginsConfigSelect').append($('<option>', {
                            nameplugin: '<?= $nameplug; ?>',
                            typebox: '<?= $productName; ?>',
                            config: 'gpio',
                            text: '<?= $nameplug; ?>'
                }));
           <?php  } ?>

                    </script>
        <?php
      
      
    }elseif($countProtocols == 1){
      $nameplug = $arrayConfigChoice[0]->getId();
       ?>
            <script>
                var nameplugin = '<?= $nameplug; ?>';
                var typebox = '<?= $productName; ?>';
                var config = 'gpio';
                callAjax(config, typebox, nameplugin);
              $('.testbtnb').hide();
              $('#choiceMode').html('Le port du plugin à été automatiquement configuré, vous pouve cliquez sur la fleche pour continuer');
              $('#pluginsConfigSelect').hide(); 
              $('#yourBoxIs').hide();        
            </script>
    <?php
       
    }
  

    if ($i == 0) {
        ?> <script>
            $('#choiceMode').hide();  
            $('.testbtnb').hide();
            $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer}}');
            $('#btn-choiceConfig').hide();
            $('#pluginsConfigSelect').hide();
            $('#bt_next').show();
        </script>
    <?php

    }
} else {
    ?> <script>
        $('#choiceMode').hide();
        $('.testbtnb').hide();
        $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer}}');
        $('#btn-choiceConfig').hide();
        $('#pluginsConfigSelect').hide();
        $('#bt_next').show();
    </script>
<?php

}

?>
<script>
  
     $('#btn-pluginConfigIgnore').click( function() {
      $('#bt_next').trigger('click');
      $('#bt_next').show();
  });
  

    $('#btn-validateConfig').on('click', function() { 
                  var countProtocols = '<?= $countProtocols; ?>';
                  if(countProtocols > 1){
                      let choiceConfig, typeBox, pluginName;            
                      choiceConfig = $('#pluginsConfigSelect option:selected').attr('config');
                      typeBox = $('#pluginsConfigSelect option:selected').attr('typebox');
                      pluginName = $('#pluginsConfigSelect option:selected').attr('nameplugin');
                      if(choiceConfig == ''){
                         $('#choiceMode').hide();
                         $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer, cliquez sur Suivant}}');
                         $('#bt_next').hide();
                      }else{
                        callAjax(choiceConfig, typeBox, pluginName);
                      }                  
                  }else{
                      $('#choiceMode').hide();
                      $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer, cliquez sur Suivant}}');
                      $('#bt_next').show();
                    
                  }
    });


    $('#pluginsConfigSelect').on('change', function() {
        $('#choiceMode').show();
        $('.textConfigAutoPlug').text('');
    });
</script>

<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
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