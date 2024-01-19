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

     var divProgressbar = document.getElementById('div_progressbar');
     var btNext = document.getElementById('bt_next');
     var btPrev = document.getElementById('bt_prev');
     var textAtlasElements = document.querySelectorAll('.textAtlas');

     btNext.style.display = 'none';
     btPrev.style.display = 'block';

    dnsInstall();

    function dnsInstall() {
       progress(20);
       document.querySelector('.textAtlas').innerHTML = '{{Le plugin OpenVpn est en cours d\'installation... Veuillez patientez}}';
       progress(40);
      $.ajax({
        type: "POST",
        url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
        data: {
          action: "dnsInstall"
        },
        dataType: 'json',
        error: function(request, status, error) {
          handleAjaxError(request, status, error);
        },
        success: function(data) {
          progress(100);
          textAtlasElements.forEach(function(element) {
            textAtlasElements.innerHTML = '';
            textAtlasElements.innerHTML = '{{Le plugin OpenVpn est en cours d\'installation... Veuillez patienter}}';
          });
        }
      });
    }


    function progress(ProgressPourcent){
        if(ProgressPourcent == -1){
          divProgressbar.removeClass('progress-bar-success progress-bar-info progress-bar-warning');
          divProgressbar.addClass('active progress-bar-danger');
          divProgressbar.width('100%');
          divProgressbar.attr('aria-valuenow',100);
          divProgressbar.html('N/A');
            return;
        }
        if(ProgressPourcent == 100){
            divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
            divProgressbar.classList.add('progress-bar-success');
            divProgressbar.style.width = ProgressPourcent + '%';
            divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
            divProgressbar.innerHTML = 'FIN';
            textAtlasElements.forEach(function(element) {
             element.style.display = 'none';
            });
            Good();
            return;
        }
          divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
          divProgressbar.classList.add('progress-bar-success');
          divProgressbar.style.width = ProgressPourcent + '%';
          divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
          divProgressbar.innerHTML = ProgressPourcent + '%';
      }

      function Good(){
        btNext.style.display = 'block';
        btNext.style.marginTop = '70px';
        var imgElement = document.querySelector('.img-atlas');
        imgElement.setAttribute('src', '<?php echo config::byKey("product_connection_image"); ?>');

      }
  </script>

  <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
  <div class="col-md-12 text-center">
    <p class="text-center">
       <h4 class="textAtlas" style="margin-top:35px;"></h4>
    </p>

    <div id="contenuTextSpan" class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
  </div>

<?php

}else{

?>

<script>
  document.getElementById('bt_next').style.display = 'block';

</script>
<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
  <p class="text-center">
     <h4 class="textAtlas" style="margin-top:35px;">Vous etes en service Pack Community. Pas de configuration OpenVpn nécessaire. Cliquez sur suivant</h4>
  </p>
</div>

<?php
} ?>
