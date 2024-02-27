<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

if (file_exists(config::byKey('path_wizard')))
  $path_wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
else
  $path_wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);


$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');
$productName = jeedom::getHardwareName();
$servicePack = '';

if ($jsonrpc->sendRequest('servicepack::info')) {
  $result = $jsonrpc->getResult();
  $servicePack = $result['licenceName'];
}

if ($servicePack != 'Community') {
?>

  <script>

     var btNext = document.getElementById('bt_next');
     var btPrev = document.getElementById('bt_prev');
     var textAtlasElements = document.querySelectorAll('.textAtlas');

     btNext.style.display = 'none';
     btPrev.style.display = 'block';

    dnsInstall();

    function dnsInstall() {
       var progressInterval;
       var progressBar = document.getElementById('div_progressbar');
       progressBar.classList.add('progress-bar-success');
       var progressValue = 0;

       function updateProgress() {
          if (progressValue >= 90) {
              clearInterval(progressInterval);
          } else {
              progressValue += 10; 
              progressBar.innerHTML = progressValue + '%';
              progressBar.style.width = progressValue + '%';
          }
       }
       // On vient lancer l'intervall pour faire avancer la barre de progression
       progressInterval = setInterval(updateProgress, 1500);

       document.querySelector('.textAtlas').innerHTML = '{{La mise en place de l\'acces distant est cours... Veuillez patientez}}';

      $.ajax({
        type: "POST",
        url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
        data: {
          action: "dnsInstall"
        },
        dataType: 'json',
        error: function(request, status, error) {
          clearInterval(progressInterval);
          handleAjaxError(request, status, error);
        },
        success: function(data) {
          clearInterval(progressInterval);
          progressBar.style.width = '100%';
          progressBar.innerHTML = 100 + '%';
          document.querySelector('.textAtlas').innerHTML = '{{La mise en place de l\'acces distant s\'est avec succès}}';
          document.getElementById('div_progressbar').innerHTML = 'FIN';
          Good();
        }
      });
    }

      function Good(){
        btNext.style.display = 'block';
        var imgElement = document.querySelector('.img-atlas');
        imgElement.setAttribute('src', '<?php echo config::byKey("product_connection_image"); ?>');
      }

  </script>
<div class="mainContainer" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
  <div><img class="img-responsive center-block img-atlas" style="width:70%;height:70%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
  <div class="col-md-12 text-center">
    <p class="text-center">
       <h4 class="textAtlas" style="margin-top:35px;"></h4>
    </p>

    <div id="contenuTextSpan" class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:30px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
  </div>
</div>
<?php

}else{

?>

<script>
  document.getElementById('bt_next').style.display = 'block';
  document.getElementById('bt_next').style.margin = 'block';

</script>
<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
  <p class="text-center">
     <h4 class="textAtlas" style="margin-top:35px;">Vous etes en service Pack Community. Pas de configuration OpenVpn nécessaire. Cliquez sur suivant</h4>
  </p>
</div>

<?php
} ?>
